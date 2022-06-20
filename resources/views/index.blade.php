<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Todo-list</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<body>

<div class="conteudo">
    <div class="topo">
        <input type="text" 
                id="InputNovaTarefa"
                placeholder="Adicione uma nova tarefa"
                >
            <button id="btnAddTarefa">
                <i class="fa fa-plus"></i>
            </button>
    </div>
    
    <ul id="listaTarefas">
    </ul>
</div>

<div id="janelaEdicao">
    <button id="janelaEdicaoBtnFechar">
        <i class="fa fa-remove fa-2x"></i>
    </button>
    <h2 id="idTarefaEdicao">#1021</h2>
    <hr>
    <form>
        <div class="frm-linha">
            <label for="nome">Nome</label>
            <input type="text" id="inputTarefaNomeEdicao">
        </div>
        <div class="frm-linha">
            <button id="btnAtualizarTarefa">Salvar</button>
        </div>
    </form>
</div>
<div id="janelaEdicaoFundo"></div>
    
    <style>
            body {
        background-color: #000;
        color: #FFF;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1rem;
        }

        .conteudo{
            margin: 0 auto;
            width: 100%;
            max-width: 450px;
            margin-top: 50px;
            margin-bottom: 50px;
            background: #2b2a2a;
            padding: 55px;
            border-radius: 12px;
        }

        .topo{
            display: flex;
            justify-content: space-between;
            margin-bottom: 35px;
        }

        .topo input{
            width: 350px;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #191818;
            outline: none;
            font-size: 1.2rem;
            background: #191818;
            color: #FFF;
        }

        .topo button{
            width: 45px;
            border-radius: 12px;
            border: 1px solid #191818;
            background: #191818;
            color: #FFF;
            outline: none;
        }

        .topo button:hover{
            background: #1f1e1e;
            cursor: pointer;
        }

        #listaTarefas{
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #listaTarefas li{
            padding: 20px;
            background: #191818;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .btnAcao{
            border-radius: 20px;
            border: 1px solid #191818;
            width: 38px;
            height: 38px;
            margin-right: 8px;
            cursor: pointer;
            background: #2b2a2a;
            color: #FFF;
            outline: none;
        }

        .btnAcao:hover{
            background: #3c3a3a;
        }

        .textoTarefa {
            overflow: hidden;
            text-overflow: ellipsis;
            width: 290px;
            white-space: nowrap;
        }

        #janelaEdicao {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #191818;
            border: 1px solid #2f2e2e;
            width: 415px;
            border-radius: 12px;
            z-index: 200;
            display: none;
        }

        #janelaEdicao.abrir {
            display: block !important;
        }

        #janelaEdicaoFundo {
            position: fixed;
            top: 0;
            background-color: #000;
            bottom: 0;
            left: 0;
            opacity: 0.9;
            z-index: 100;
            right: 0;
            display: none;
        }

        #janelaEdicaoFundo.abrir {
            display: block !important;
        }

        #janelaEdicaoBtnFechar {
            position: absolute;
            top: -25px;
            right: -18px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid #2d2c2c;
            background: #2d2c2c;
            color: #FFF;
            outline: none;
            cursor: pointer;
        }

        form {
            width: 100%;
            margin-top: 20px;
        }

        .frm-linha {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .frm-linha label {
            margin-bottom: 7px;
        }

        .frm-linha input {
            padding: 15px;
            border-radius: 12px;
            outline: none;
            border: 1px solid #191818;
            font-size: 1.2rem;
            background: #2d2c2c;
            color: #FFF;
        }

        .frm-linha button {
            background: #2d2c2c;
            border: 1px solid #191818;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 12px;
            color: #CCC;
            cursor: pointer;
            height: 50px;
            font-size: 1.3rem;
            outline: none;
        }

        .frm-linha button:hover {
            background: #3c3a3a;
        }

    </style>
    
    <script text="text/javascript">

        function initialyze() {
            getTasks();
        }

        function getTasks() {
            $.ajax({
                type: "GET",
                url: '/todolist',
                success: function (data) {
                    console.log(data);
                    if (data.length > 0) {
                        const table = document.getElementsByTagName('tbody')[0];
                        table.innerHTML = "";
                        for (var i = 0; i < data.length; i++) {
                            try {
                                const row = table.insertRow(i);
                                const cell1 = row.insertCell(0);
                                const cell2 = row.insertCell(1);
                                const cell3 = row.insertCell(2);
                                const cell4 = row.insertCell(3);
                                cell1.innerHTML = data[i].id;
                                cell2.innerHTML = data[i].description;
                                cell3.innerHTML = `<button class="btn btn-primary" onclick="openEditModal(${data[i].id},'${data[i].description}')"><i class="fa fa-edit"></i></button>`;
                                cell4.innerHTML = '<button class="btn btn-danger" onclick="deleteTask(' + data[i].id + ')"><i class="fa fa-trash"></i></button>';
                            } catch (error) {
                                console.log(error);
                            }

                        }
                    } else {
                        var row = table.insertRow(0);
                        var cell = row.insertCell(0);
                        cell.innerHTML = 'No tasks';
                    }
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        function saveTasks() {
            const task = document.getElementById('taskInput').value;
            $.ajax({
                type: "POST",
                url: '/todolist',
                data: {
                    description: task
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    getTasks();
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        function deleteTasks(id) {
            $.ajax({
                type: "DELETE",
                url: '/todolist/${id}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    getTasks();
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        function openEditModal(id, description) {
            $('#editionModal').modal('show');
            $('#task-id').val(id);
            $('#task-description').val(description);
        }

        function edit() {
            var id = $('#task-id').val();
            var description = $('#task-description').val();
            $.ajax({
                type: "PUT",
                url: '/todolist/${id}',
                data: {
                    description: description
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    getTasks();
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        
        let inputNovaTarefa = document.querySelector('#inputNovaTarefa');
        let btnAddTarefa = document.querySelector('#btnAddTarefa');
        let listaTarefas = document.querySelector('#listaTarefas');
        let janelaEdicao = document.querySelector('#janelaEdicao');
        let janelaEdicaoFundo = document.querySelector('#janelaEdicaoFundo');
        let janelaEdicaoBtnFechar = document.querySelector('#janelaEdicaoBtnFechar');
        let btnAtualizarTarefa = document.querySelector('#btnAtualizarTarefa');
        let idTarefaEdicao = document.querySelector('#idTarefaEdicao');
        let inputTarefaNomeEdicao = document.querySelector('#inputTarefaNomeEdicao');
        const qtdIdsDisponiveis = Number.MAX_VALUE;

       
        InputNovaTarefa.addEventListener('keypress', (e) =>{

            if(e.keyCode == 13) {
                let tarefa = {
                    nome: InputNovaTarefa.value,
                    id: gerarId(),
                }
                adicionarTarefa(tarefa);
            }
        });

        janelaEdicaoBtnFechar.addEventListener('click', (e) =>{
            alternarJanelaEdicao();
        });

        btnAddTarefa.addEventListener('click', (e) =>{

            let tarefa = {
                    nome: InputNovaTarefa.value,
                    id: gerarId(),
                }
                adicionarTarefa(tarefa);
        });
        
        btnAtualizarTarefa.addEventListener('click', (e) =>{
            e.preventDefault();
            
            let idTarefa = idTarefaEdicao.innerHTML.replace('#', '');

            let tarefa = {
                nome: inputTarefaNomeEdicao.value,
                id: idTarefa
            }

            let tarefaAtual = document.getElementById(''+idTarefa+'');

            if(tarefaAtual) {
                let li = criarTagLI(tarefa);
                listaTarefas.replaceChild(li, tarefaAtual);
                alternarJanelaEdicao();
            } else {
                alert('Elemento HTML nao encontrado!');
            }
        });

        function gerarId() {
            return Math.floor(Math.random() * 3000);
        }

        function adicionarTarefa(tarefa) {
            let li = criarTagLI(tarefa);
            listaTarefas.appendChild(li);
            InputNovaTarefa.value = '';
        }

        function criarTagLI(tarefa) {

            let li = document.createElement('li');
            li.id = tarefa.id;

            let span = document.createElement('span');
            span.classList.add('textoTarefa');
            span.innerHTML = tarefa.nome;

            let div = document.createElement('div');

            let btnEditar = document.createElement('button');
            btnEditar.classList.add('btnAcao');
            btnEditar.innerHTML = '<i class="fa fa-pencil"></i>';
            btnEditar.setAttribute('onclick', 'editar('+tarefa.id+')');

            let btnExcluir = document.createElement('button');
            btnExcluir.classList.add('btnAcao');
            btnExcluir.innerHTML = '<i class="fa fa-trash"></i>';
            btnExcluir.setAttribute('onclick', 'excluir('+tarefa.id+')');

            div.appendChild(btnEditar);
            div.appendChild(btnExcluir);

            li.appendChild(span);
            li.appendChild(div);
            return li;
        }

        function editar(idTarefa) {
            let li = document.getElementById(''+ idTarefa + '');
            if(li) {
                idTarefaEdicao.innerHTML = '#' + idTarefa;
                inputTarefaNomeEdicao.value = li.innerText;
                alternarJanelaEdicao();
            } else {
                alert('Elemento HTML nao encontrado!');
            }
        }

        function excluir(idTarefa) {
            let confirmacao = window.confirm('Tem certeza que deseja excluir? ');
            if(confirmacao) {
                let li = document.getElementById(''+ idTarefa + '');
                if(li) {
                    listaTarefas.removeChild(li);
                }
            } else {
                alert('Elemento HTML nao encontrado!');
            }
        }

        function alternarJanelaEdicao() {
            janelaEdicao.classList.toggle('abrir');
            janelaEdicaoFundo.classList.toggle('abrir');
        }

    </script>

</body>
</html>