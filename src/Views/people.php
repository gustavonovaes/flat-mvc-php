<?php $title = "App" ?>

<?php ob_start() ?>

<div class="container">
    <main>

        <header>
            <div class="header-title">
                Pessoas
            </div>

            <button class="header-button btn btn-adicionar">
                &#43; Adicionar
            </button>
        </header>

        <article>

            <div class="wrapper">

                <table class="table">

                    <colgroup>
                        <col span="1"
                             style="width: 25%;">
                        <col span="1"
                             style="width: 25%;">
                        <col span="1"
                             style="width: 40%;">
                        <col span="1"
                             style="width: 15%;">
                    </colgroup>

                    <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Endereço</th>
                        <th class="acoes text-center">&#9881;</th>
                    </tr>

                    </thead>

                    <tbody>

                    <!-- Layout -->
                    <tr data-id=""
                        class="pessoa layout hidden pendente">

                        <td class="nome"
                            contenteditable="true"
                            placeholder="Nome..."
                            data-pattern="^[a-z ,.'-]+$"></td>

                        <td class="sobrenome"
                            contenteditable="true"
                            placeholder="Sobrenome..."
                            data-pattern="^[a-z ,.'-]+$"></td>

                        <td class="endereco"
                            contenteditable="true"
                            placeholder="Endereço..."
                            data-pattern="^\s*\S+(?:\s+\S+){2}"></td>

                        <td class="acoes text-center">
                            <button class="btn btn-cancelar"></button>
                            <button class="btn btn-salvar"></button>
                            <button class="btn btn-editar"></button>
                            <button class="btn btn-excluir"></button>
                        </td>

                    </tr>

                    <tr class="nenhum-registro <?= (count($people) > 0) ? 'hidden': '' ?>">
                        <td colspan="4"
                            class="text-center">Nenhum Registro
                        </td>
                    </tr>

                    <?php foreach ($people as $person): ?>
                        <tr data-id="<?= $person->id ?>"
                            class="pessoa">

                            <td class="nome"
                                contenteditable="false"
                                data-pattern="^[a-z ,.'-]+$">
                                <?= $person->firstname ?>
                            </td>

                            <td class="sobrenome"
                                contenteditable="false"
                                data-pattern="^[a-z ,.'-]+$">
                                <?= $person->lastname ?>
                            </td>

                            <td class="endereco"
                                contenteditable="false"
                                data-pattern="^\s*\S+(?:\s+\S+){2}">
                                <?= $person->address ?>
                            </td>

                            <td class="acoes text-center">
                                <button class="btn btn-cancelar"></button>
                                <button class="btn btn-salvar"></button>
                                <button class="btn btn-editar"></button>
                                <button class="btn btn-excluir"></button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </article>

        <footer>
            <div class="footer-item">
                Total de Pessoas: <span class="total-pessoas"><?= count($people); ?></span>
            </div>
        </footer>

    </main>
</div>

<script>

    function error_handler(err) {

        console.error(err);

        if (err.status == 200) {
            return alert('DataType inválido.');
        }

        var message = err.responseJSON ? err.responseJSON.message : err.status + ' - ' + err.statusText;

        return alert(message);
    }

    function salvar(nome, sobrenome, endereco) {
        return $.post('/people', {
            'firstname': nome,
            'lastname':  sobrenome,
            'address':   endereco
        }, null, 'json').fail(error_handler);
    }

    function editar(id, nome, sobrenome, endereco) {
        return $.post('/people', {
            '_method':   'PUT',
            'id':        id,
            'firstname': nome,
            'lastname':  sobrenome,
            'address':   endereco
        }, null, 'json').fail(error_handler);
    }

    function excluir(id) {
        return $.post('/people', {
            '_method': 'DELETE',
            'id':      id
        }, null, 'json').fail(error_handler);
    }

    function toggleStatusPendente($tr) {

        if ($tr.hasClass('pendente')) {
            $tr.removeClass('pendente');
            $tr.find('td[contenteditable]').attr('contenteditable', false);
            return;
        }

        $tr.addClass('pendente');
        $tr.find('td[contenteditable]').attr('contenteditable', true);
    }

    $(function () {

        /* Setup */

        // Fixa cabeçalho da Tabela
        var $table = $('table.table');
        $table.floatThead({
            responsiveContainer: function ($table) {
                return $table.closest('.wrapper');
            }
        });

        $table.on('keyup', 'td[contenteditable]', function () {
            var $td = $(this);

            if (!$td.text().length) {
                $td.removeClass('invalido');
                return;
            }

            var regex = new RegExp($td.data('pattern'), "i");

            if ( !regex.test($td.text()) ) {
                $td.addClass('invalido');
                return;
            }

            $td.removeClass('invalido');
        });

        var $body = $('body');

        /* Button Events */

        $body.find('.btn-adicionar').click(function () {

            // Esconde linha "Nenhum Registro"
            $table.find('tr.nenhum-registro:not(.hidden)').addClass('hidden');

            // Cria uma cópia da linha de layout e inclui na tabela
            var $tr = $table.find('tr.layout').clone().removeClass('layout hidden');
            $table.find('tbody').append($tr);
            $tr.find('td:first').focus();
        });

        $body.on('click', '.btn-cancelar', function () {

            // Se for um novo registro remove linha, se não, cancela a edição
            $tr = $(this).closest('tr');
            if ($tr.data('id')) {
                toggleStatusPendente($tr);
                return;
            }
            $tr.remove();

            $body.trigger('updateLinhaSemRegistro');
        });

        $body.on('click', '.btn-salvar', function () {
            $tr = $(this).closest('tr');

            var id = $tr.data('id');

            if ($tr.find('td.invalido').length) {
                alert("Campo inválido");
                return;
            }

            var nome      = $tr.find('.nome').text(),
                descricao = $tr.find('.sobrenome').text(),
                endereco  = $tr.find('.endereco').text();


            if (id) {
                return editar(id, nome, descricao, endereco).done(function () {

                    toggleStatusPendente($tr);
                    console.info('Atualizou #' + id);
                });
            }

            return salvar(nome, descricao, endereco).done(function (response) {

                $tr.data('id', response.id);

                toggleStatusPendente($tr);

                $body.trigger('updateTotalPessoas');
                console.info('Salvou #' + response.id);
            });
        });

        $body.on('click', '.btn-editar', function () {
            $tr = $(this).closest('tr');
            toggleStatusPendente($tr);
            $tr.find('td:first').focus();
        });

        $body.on('click', '.btn-excluir', function () {
            $tr = $(this).closest('tr');

            var id = $tr.data('id');

            excluir(id).done(function (response) {
                $tr.remove();
                $body.trigger('updateLinhaSemRegistro');
                $body.trigger('updateTotalPessoas');
                console.info('Excluiu #' + id);
            })
        });

        /* Custom Events */

        $body.on('updateTotalPessoas', function () {
            var total = $table.find('tbody tr.pessoa:not(.pendente)').length;
            $body.find('.total-pessoas').text(total);
        });

        $body.on('updateLinhaSemRegistro', function () {
            if ($table.find('tr.pessoa:not(.hidden)').length == 0) {
                $table.find('tr.nenhum-registro.hidden').removeClass('hidden');
            }
        });
    });
</script>

<?php $content = ob_get_clean() ?>

<?php include __DIR__ . '/layout.php' ?>
