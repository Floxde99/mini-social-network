<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($title) ? htmlspecialchars($title) : 'ClicnClac' ?></title>
  <!-- Tailwind CSS via Play CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <nav class="bg-white border-b shadow-md">
    <div class="container mx-auto flex items-center justify-between p-4">
      <!-- Logo / Nom du site -->
      <a href="/" class="text-2xl font-bold text-blue-600">ClicnClac</a>
      <!-- Liens de navigation -->
      <ul class="flex space-x-4">
        
        <?php if (!empty($_SESSION['user'])): ?>
          <li><a href="/main" class="hover:text-blue-800">Accueil</a></li>
          <li><a href="/posts/create" class="hover:text-blue-800">Créer un Post</a></li>
          <li><a href="/logout" class="hover:text-red-600">Déconnexion</a></li>
        <?php else: ?>
          <li><a href="/" class="hover:text-blue-800">Accueil</a></li>
          <li><a href="/login" class="hover:text-blue-800">Connexion</a></li>
          <li><a href="/register" class="hover:text-blue-800">Inscription</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

<?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border-l-4 border-green-400 p-4 fixed top-20 right-4 max-w-md rounded-lg shadow-lg z-50" id="success-banner">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button class="inline-flex text-green-400 hover:text-green-500" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const banner = document.getElementById('success-banner');
            if (banner) banner.remove();
        }, 5000);
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<main class="container mx-auto p-4">
