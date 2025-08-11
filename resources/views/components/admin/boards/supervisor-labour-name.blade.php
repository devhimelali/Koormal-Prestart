<div class="card name-card border border-2 border-success mb-0">
    <div class="name-card-body">
        <h5 class="mb-1 text-center">Supervisor Name :</h5>
        <p class="text-muted mb-0 text-center">{{ $supervisor?->name ?? 'N/A' }}</p>
    </div>

</div>
<div class="card name-card border border-2 border-success mb-0">
    <div class="name-card-body">
        <h5 class="mb-1 text-center">Labour Name :</h5>
        <p class="text-muted mb-0 text-center">{{ $labor->name ?? 'N/A' }}</p>
    </div>
</div>

<style>
    .name-card-body {
        padding: 0.5rem;
        border-radius: 0% 0% 4px 4px;
    }

    .name-card {
        min-width: 350px;
        max-width: 450px;
    }
</style>
