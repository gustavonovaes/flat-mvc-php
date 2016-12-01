<?php $title = "App" ?>

<?php ob_start() ?>

<div class="container">
    <main>

        <header>
            <div class="header-title">
                <h2>Pessoas</h2>
            </div>

            <button class="header-button">
                &#43; Adicionar
            </button>
        </header>

        <article>

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

                <tr data-id=""
                    class="layout hidden">
                    <td class="nome"></td>
                    <td class="sobrenome"></td>
                    <td class="endereco"></td>
                </tr>

                <?php foreach ($people as $person): ?>
                    <tr data-id="<?= $person->id ?>">

                        <td class="nome">
                            <?= $person->firstname ?>
                        </td>

                        <td class="sobrenome">
                            <?= $person->lastname ?>
                        </td>

                        <td class="endereco">
                            <?= $person->address ?>
                        </td>

                        <td class="acoes">
                            <button class="btn btn-salvar invisible"></button>
                            <button class="btn btn-editar"></button>
                            <button class="btn btn-excluir"></button>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>

        </article>

        <footer>
            <div class="footer-item">
                Total de itens: <span><?= count($people); ?></span>
            </div>
        </footer>

    </main>
</div>

<script>
    $(function () {
        var $table = $('table.table');
        $table.floatThead({
            scrollContainer: function ($table) {
                return $table.closest('article');
            }
        });
    });
</script>

<?php $content = ob_get_clean() ?>

<?php include __DIR__ . '/layout.php' ?>
