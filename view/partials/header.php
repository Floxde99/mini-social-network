
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($title) ? htmlspecialchars($title) : 'Mini Social Network' ?></title>
  <!-- Tailwind CSS via Play CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <nav class="bg-white border-b shadow-md">
    <div class="container mx-auto flex items-center justify-between p-4">
      <!-- Logo / Nom du site -->
      <a href="/" class="text-2xl font-bold text-blue-600">MiniSocial</a>
      <!-- Liens de navigation -->
      <ul class="flex space-x-4">
        <li><a href="/" class="hover:text-blue-800">Accueil</a></li>
        <?php if (!empty($_SESSION['user'])): ?>
          <li><a href="/posts/create" class="hover:text-blue-800">Créer un Post</a></li>
          <li><a href="/logout" class="hover:text-red-600">Déconnexion</a></li>
        <?php else: ?>
          <li><a href="/login" class="hover:text-blue-800">Connexion</a></li>
          <li><a href="/register" class="hover:text-blue-800">Inscription</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  <main class="container mx-auto p-4">
