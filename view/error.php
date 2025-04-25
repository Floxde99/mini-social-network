<?php
// Si un message n'est pas passé, on définit un message générique
$message = $message ?? 'Une erreur est survenue. Veuillez réessayer plus tard.';
$title = 'Erreur';
include __DIR__ . '/partials/header.php';
?>
<div class="container mx-auto p-4">
  <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
    <strong class="font-bold">Erreur : </strong>
    <span class="block sm:inline"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></span> <!-- Sécurisation XSS :contentReference[oaicite:0]{index=0} -->
  </div>
  <div class="mt-4">
    <a href="/" class="text-blue-600 hover:underline">← Retour à l’accueil</a>
  </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
