<?php
// Titre de la page et récupération des posts passés par MainController
$title = 'Flux de Posts';
$description = 'Flux de posts de l\'application.';
$posts = $posts ?? [];

include __DIR__ . '/partials/header.php'; // Inclusion du header (HTML + nav) :contentReference[oaicite:10]{index=10}
?>

<?php if (empty($posts) && !empty($_SESSION['user'])): ?>
  <p class="text-center text-gray-600">Aucun post disponible.</p>
<?php else: ?>
  <?php foreach ($posts as $post): // Boucle d'affichage des posts :contentReference[oaicite:11]{index=11} ?>
    <div class="bg-white shadow rounded-lg p-4 mb-4">
      <h2 class="text-xl font-semibold"><?= htmlspecialchars($post->getTitle(), ENT_QUOTES, 'UTF-8') // Sécurisation XSS :contentReference[oaicite:12]{index=12} ?></h2>
      <p class="text-gray-700"><?= nl2br(htmlspecialchars($post->getContent(), ENT_QUOTES, 'UTF-8')) // Conservation des sauts de ligne :contentReference[oaicite:13]{index=13} ?></p>
      <p class="text-sm text-gray-500 mt-2">
        Par <?= htmlspecialchars($post->getAuthor()->getUsername(), ENT_QUOTES, 'UTF-8') ?> 
        le <?= $post->getCreatedAt()->format('d/m/Y H:i') ?>
      </p>
      <?php if (!empty($_SESSION['user']) && $_SESSION['user']->getId() === $post->getAuthor()->getId()): ?>
        <div class="flex space-x-2 mt-2">
          <a href="/posts/edit?id=<?= $post->getId() ?>" class="text-blue-600 hover:underline">Modifier</a>
          <form action="/posts/delete" method="post" onsubmit="return confirm('Supprimer ce post ?');">
            <input type="hidden" name="id" value="<?= $post->getId() ?>">
            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; // Inclusion du footer :contentReference[oaicite:14]{index=14} ?>
