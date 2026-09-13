<?php
require_once 'app.php';
require_login();

$id = user()['id'];
$q = db()->prepare("SELECT COALESCE(SUM(CASE WHEN tipo='receita' THEN valor ELSE 0 END),0) receitas,
    COALESCE(SUM(CASE WHEN tipo='despesa' THEN valor ELSE 0 END),0) despesas
    FROM transacoes WHERE usuario_id=?");
$q->execute([$id]);
$tot = $q->fetch();
$saldo = (float)$tot['receitas'] - (float)$tot['despesas'];

$r = db()->prepare("SELECT categoria, SUM(valor) valor FROM transacoes
    WHERE usuario_id=? AND tipo='despesa' GROUP BY categoria ORDER BY valor DESC LIMIT 6");
$r->execute([$id]);
$cats = $r->fetchAll();
$chartLabels = array_map(static fn(array $row): string => (string)$row['categoria'], $cats);
$chartValues = array_map(static fn(array $row): float => (float)$row['valor'], $cats);
$chartLabelsJson = json_encode($chartLabels, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
$chartValuesJson = json_encode($chartValues, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

layout_start('Dashboard');
?>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card stat p-3 h-100"><small>Saldo atual</small><strong class="fs-3 <?= $saldo < 0 ? 'text-danger' : 'text-success' ?>"><?=money($saldo)?></strong></div></div>
    <div class="col-md-4"><div class="card stat p-3 h-100"><small>Receitas</small><strong class="fs-3 text-success"><?=money($tot['receitas'])?></strong></div></div>
    <div class="col-md-4"><div class="card stat p-3 h-100"><small>Despesas</small><strong class="fs-3 text-danger"><?=money($tot['despesas'])?></strong></div></div>
</div>
<div class="d-flex flex-wrap gap-2 mb-4"><a class="btn btn-primary" href="registro_gastos.php"><i class="bi bi-plus"></i> Novo lançamento</a><a class="btn btn-outline-secondary" href="relatorio_financeiro.php">Ver relatório</a></div>
<div class="row g-4">
    <div class="col-xl-5">
        <div class="card p-4 chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-2"><h2 class="h5 mb-0">Despesas por categoria</h2><span class="text-muted small">Top 6</span></div>
            <?php if (!$cats): ?><p class="text-muted mb-0">Ainda não há despesas cadastradas.</p>
            <?php else: ?><div class="chart-wrap"><canvas id="expensesChart" aria-label="Gráfico de despesas por categoria"></canvas></div><?php endif; ?>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card p-4 h-100"><h2 class="h5">Detalhamento</h2><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Categoria</th><th class="text-end">Total</th></tr></thead><tbody><?php foreach ($cats as $c): ?><tr><td><?=e($c['categoria'])?></td><td class="text-end"><?=money($c['valor'])?></td></tr><?php endforeach; ?></tbody></table></div></div>
    </div>
</div>
<?php if ($cats): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(() => {
    const labels = <?= $chartLabelsJson ?>;
    const values = <?= $chartValuesJson ?>;
    const colors = ['#4338ca', '#0891b2', '#059669', '#f59e0b', '#e11d48', '#7c3aed'];
    new Chart(document.getElementById('expensesChart'), {
        type: 'doughnut',
        data: { labels, datasets: [{ data: values, backgroundColor: colors, borderColor: '#fff', borderWidth: 3, hoverOffset: 10 }] },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '62%',
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } },
                tooltip: { callbacks: { label: context => ` ${context.label}: R$ ${context.parsed.toLocaleString('pt-BR', {minimumFractionDigits: 2})}` } } }
        }
    });
})();
</script>
<?php endif; ?>
<?php layout_end(); ?>
