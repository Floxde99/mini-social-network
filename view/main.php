<?php
$title = 'Accueil';
include __DIR__ . '/partials/header.php';
?>

<div class="max-w-4xl mx-auto mt-8 px-4">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Fil d'actualité</h1>
        <a href="/create-post" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nouveau post
        </a>
    </div>

    <?php if (empty($formattedPosts)): ?>
        <div class="text-center py-10 bg-white rounded-lg shadow">
            <p class="text-gray-500">Aucun post pour le moment.</p>
            <p class="mt-2 text-sm text-gray-400">Soyez le premier à partager quelque chose !</p>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($formattedPosts as $post): ?>
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($post['title']) ?></h2>
                    <p class="text-gray-600 mb-4"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>Par <?= htmlspecialchars($post['author']['username']) ?></span>
                        <span>Le <?= $post['created_at']->format('d/m/Y à H:i') ?></span>
                    </div>
                    
                    <?php if ($_SESSION['user']['iduseur'] === $post['author']['id']): ?>
                        <div class="flex space-x-4 mt-4 pt-4 border-t">
                            <a href="/edit-post?id=<?= $post['id'] ?>" 
                               class="text-indigo-600 hover:text-indigo-800">Modifier</a>
                            <form action="/delete-post" method="POST" class="inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800">Supprimer</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
