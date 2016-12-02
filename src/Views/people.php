<?php $title = "App" ?>

<?php ob_start() ?>

<div class="container">
    <main>

        <header>
            <div class="header-title">
                Pessoas
            </div>

            <button class="header-button btn-adicionar">
                &#43; Adicionar
            </button>
        </header>

        <article>

            <div class="wrapper">

                <table class="table">

                    <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Endereço</th>
                        <th class="acoes">&#9881;</th>
                    </tr>

                    </thead>

                    <tbody>

                    <!-- Layout -->
                    <tr data-id=""
                        class="hidden pendente">

                        <td class="nome"
                            contenteditable="true"
                            placeholder="Nome..."
                            data-pattern="/^[a-z ,.'-]+$/i"></td>

                        <td class="sobrenome"
                            contenteditable="true"
                            placeholder="Sobrenome..."
                            data-pattern="/^[a-z ,.'-]+$/i"></td>

                        <td class="endereco"
                            contenteditable="true"
                            placeholder="Endereço..."
                            data-pattern="/^\s*\S+(?:\s+\S+){2}/"></td>

                        <td class="acoes">
                            <button class="btn btn-cancelar"></button>
                            <button class="btn btn-salvar"></button>
                            <button class="btn btn-editar"></button>
                            <button class="btn btn-excluir"></button>
                        </td>

                    </tr>

                    <?php foreach ($people as $person): ?>
                        <tr data-id="<?= $person->id ?>">

                            <td class="nome"
                                contenteditable="false"
                                data-pattern="/^[a-z ,.'-]+$/i">
                                <?= $person->firstname ?>
                            </td>

                            <td class="sobrenome"
                                contenteditable="false"
                                data-pattern="/^[a-z ,.'-]+$/i">
                                <?= $person->lastname ?>
                            </td>

                            <td class="endereco"
                                contenteditable="false"
                                data-pattern="/^\s*\S+(?:\s+\S+){2}/">
                                <?= $person->address ?>
                            </td>

                            <td class="acoes">
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

    $(function () {

        // Setup

        var $table = $('table.table');
        $table.floatThead({
            responsiveContainer: function ($table) {
                return $table.closest('.wrapper');
            }
        });

        var $body = $('body');

        // Button Events

        $body.find('.btn-adicionar').click(function () {
            var $tr = $table.find('tr.hidden').clone().removeClass('hidden');
            $table.find('tbody').append($tr);
            $tr.find('td:first').focus();
        });

        $body.on('click', '.btn-cancelar', function () {
            $tr = $(this).closest('tr');

            if ($tr.data('id')) {
                return $tr.removeClass('pendente');
            }

            $tr.remove();
        });

        $body.on('click', '.btn-salvar', function () {
            $tr = $(this).closest('tr');

            var id = $tr.data('id');

            var nome      = $tr.find('.nome').text(),
                descricao = $tr.find('.sobrenome').text(),
                endereco  = $tr.find('.endereco').text();

            if (id) {
                return editar(id, nome, descricao, endereco).done(function () {

                    $tr.removeClass('pendente');
                    $tr.find('td[contenteditable]').attr('contenteditable', false);

                    console.info('Atualizou #' + id);
                });
            }

            return salvar(nome, descricao, endereco).done(function (response) {

                $tr.data('id', response.id);

                $tr.removeClass('pendente');
                $tr.find('td[contenteditable]').attr('contenteditable', false);

                $body.trigger('updateTotalPessoas');
                console.info('Salvou #' + response.id);
            });
        });

        $body.on('click', '.btn-editar', function () {
            $tr = $(this).closest('tr');

            $tr.addClass('pendente');
            $tr.find('td[contenteditable]').attr('contenteditable', true);
        });

        // Custom Events

        $body.on('updateTotalPessoas', function () {
            var total = $table.find('tbody tr:not(.hidden)').length;
            $body.find('.total-pessoas').text(total);
        })
    });
</script>

<?php $content = ob_get_clean() ?>

<?php include __DIR__ . '/layout.php' ?>
