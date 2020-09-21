<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Option;
use App\Poll;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $polls = Poll::all();
        return view('admin.poll.list')->with('polls', $polls); //pagina inicial mostra todas as enquetes
    }

    public function listNaoInciadas()
    {
        $pollsnaoiniciadas = Poll::where('data_inicio', '>', Carbon::now())->get();
        return view('admin.poll.naoIniciada')->with('pollsnaoiniciadas', $pollsnaoiniciadas); //pagina de enquetes nao listados
    }

    public function emAndamento()
    {
        $polls = Poll::all();
        return view('admin.poll.emAndamento')->with('polls', $polls); //enquetes que ainda nao foram finalizadas
    }

    public function finalizadas()
    {
        $pollsfinalizados = Poll::where('data_fim', '<', Carbon::now())->get();
        return view('admin.poll.finalizadas')->with('pollsfinalizados', $pollsfinalizados); //enquetes que ja foram finalizadas
    }

    public function create()
    {
        return view('admin.poll.create'); //leva para a pagina que cria as enquetes
    }

    public function show(Poll $poll)
    {
        $options = Option::where('polls_id', '=', $poll->id)->orderBy('id', 'asc')->get();
        $total = Option::where('polls_id', '=', $poll->id)->sum('qtd_votos');
        return view('admin.poll.show')
            ->with(['poll' => $poll, 'options' => $options, 'total' => $total]); //mostra uma enquete em especifico (botao visualizar na tabela)
    }

    public function store(Request $request) //cadastra enquetes
    {
        $validatedData = $request->validate([ //aqui pensei em fazer uma validação para ter nome unico cada enquete
            'titulo' => 'required|unique:polls',
            [
                'titulo.required' => 'titulo ja cadastrado no banco, por favor insira outro', //
            ]
        ]);
        $tira_espaco = str_replace(' ', '', $request->input('opcoes')); //tiro os espaços que o usuario pode colocar no input de inserir uma opcao de enquete.
        $options = explode(",", $tira_espaco); //coloca virgula entre as opcoes da enquete no input
        if (count($options) > 2) { //verifica se foi cadastrado no minimo 3 opcoes na enquete
            $poll = new Poll; //aqui se inicia processo de cadastro de enquete recebendo dados do formulario
            $poll->user_id = Auth::user()->id;
            $poll->titulo = request()->titulo;
            $poll->data_inicio = request()->data_inicio;
            $poll->data_fim = request()->data_fim; //aqui termina de receber dados do formulario
            $dataIni = date('d-m-Y', strtotime($poll->data_inicio)); //conversao de data inserida para comparação
            $horaIni = date('H:i', strtotime($poll->data_inicio));//conversao de data inserida para comparação
            $horaFim = date('H:i', strtotime($poll->data_fim));//conversao de data inserida para comparação
            $dataFim = date('d-m-Y', strtotime($poll->data_fim));//conversao de data inserida para comparação

            if ($poll->data_inicio < Carbon::now()) { //para ver se data de inicio nao é menor que data atual, ai se for nao deixa cadastrar
                return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser menor que a data atual'); //retorna mensagem na tela
            } elseif ($poll->data_inicio > $poll->data_fim) { //verifica se a data de inicio é maior que data atual, se for nao deixa cadastrar
                return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser maior que a data fim'); // retorna mensagem de erro
            } elseif ($poll->data_fim < Carbon::now()) { //verifica se data de fim da enquete é menor que data atual, se for nao deixa cadastrar
                return redirect()->route('admin.poll.create')->with('error', 'data de fim não pode ser menor que a data atual'); //retorna erro
            } elseif ($poll->data_inicio == $poll->data_fim) { //verifica se as datas dd-mm-yyyy sao iguais, se for entra na condicao de horas
                if ($horaIni > $horaFim) { //hora de inicio nao pode ser maior que hora de fim
                    return redirect()->route('admin.poll.create')->with('error', 'hora de inicio nao pode ser maior que hora de fim');
                }
                if ($horaFim < $horaIni) { //hora de fim nao pode ser menor que hora de inicio
                    return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser menor que hora de inicio');
                }
                if ($horaFim == $horaIni) { //horas nao podem ser iguais
                    return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser igual hora de inicio');
                }
            }

            $poll->save(); //cadastra na tabela enquete
            foreach ($options as $key => $value) { //pegando todas as opcoes colocadas no input e inserindo no banco com o id da enquete em questao

                $option = new Option;
                $option->polls_id = $poll->id;
                $option->opcao = $value;
                $option->save(); //salvando cada enquete que passa no foreach
            }
            return redirect()->route('admin.poll.index')->with('success', 'cadastrado com sucesso'); //redireciona para pagina inicial
        } else {
            return redirect()->route('admin.poll.create')->with('error', 'devem ser cadastrados no minimo 3 opções'); //redirecionamento caso nao tenha colocado no minimo 3 opcoes
        }
    }

    public function edit(Poll $poll)
    {
        $options = Option::where('polls_id', '=', $poll->id)->get(); //pega as opcoes de uma enquete
        return view('admin.poll.edit')->with(['poll' => $poll, 'options' => $options]);//leva para pagina para editar enquete
    }

    public function update(Request $request, Poll $poll) //atualizar enquete especifica
    {
        $pol = Poll::find($poll->id); //pega a enquete em questao
        $options = Option::where('polls_id', '=', $poll->id)->get(); //pega as opcoes dessa enquete

        if (isset($pol) && isset($options)) { //verifica se enquete opcoes nao estao vazias
            $tira_espaco = str_replace(' ', '', $request->input('opcoes')); //tira espacos do input
            $opt = explode(",", $tira_espaco); //coloca virgula
            if (count($opt) > 2) { //verifica se tem no minimo duas opcoes na enquete a ser atualizada
                $pol->user_id = Auth::user()->id; //processo de atualizacao inicio
                $pol->titulo = request()->titulo;
                $pol->data_inicio = request()->data_inicio;
                $pol->data_fim = request()->data_fim;
                $pol->save(); //processo de atualizacao fim
                //aqui decidi nao colocar validações dos campos como na funcao de cadastrar, pois como é uma atualização de algo ja cadastrado nao vi necessidade
                foreach ($opt as $key => $value) { //atualiza opcoes, colocando novas opcoes para uma enquete, só não consegui fazer deletar uma opção em especifico dessa enquete, só adicionar
                    $option = Option::where('opcao', 'like', '%' . $opt[$key])->first();
                    if (!$option) {

                        Option::create([
                            'opcao' => $value,
                            'polls_id' => $poll->id
                        ]);
                    }
                }
                return redirect()->route('admin.poll.index')->with('success', 'atualizado com sucesso');
            } else {
                return redirect()->route('admin.poll.edit', $poll)->with('error', 'devem ser cadastrados no minimo 3 opções');
            }
        }
    }

    public function destroy(Poll $poll) //deleta uma enquete
    {
        $poll->delete();
        return redirect()->route('admin.poll.index')->with('error', $poll->titulo . ' has deleted successfully');
    }
}
