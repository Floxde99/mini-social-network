<?php
$title = 'Contact';
include __DIR__ . '/partials/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Contactez-nous
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Nous vous répondrons dans les plus brefs délais
            </p>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="bg-white shadow rounded-lg p-8">
            <form action="/contact" method="post" class="space-y-6">
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="name" id="name" required
                               class="appearance-none relative block w-full px-3 py-2 mt-1
                                      border border-gray-300 rounded-md
                                      placeholder-gray-500 text-gray-900
                                      focus:outline-none focus:ring-indigo-500 
                                      focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="Votre nom">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required
                               class="appearance-none relative block w-full px-3 py-2 mt-1
                                      border border-gray-300 rounded-md
                                      placeholder-gray-500 text-gray-900
                                      focus:outline-none focus:ring-indigo-500 
                                      focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="votre@email.com">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
                        <input type="text" name="subject" id="subject" required
                               class="appearance-none relative block w-full px-3 py-2 mt-1
                                      border border-gray-300 rounded-md
                                      placeholder-gray-500 text-gray-900
                                      focus:outline-none focus:ring-indigo-500 
                                      focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="Sujet de votre message">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="message" id="message" rows="4" required
                                  class="appearance-none relative block w-full px-3 py-2 mt-1
                                         border border-gray-300 rounded-md
                                         placeholder-gray-500 text-gray-900
                                         focus:outline-none focus:ring-indigo-500 
                                         focus:border-indigo-500 focus:z-10 sm:text-sm"
                                  placeholder="Votre message..."></textarea>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center 
                                   py-2 px-4 border border-transparent text-sm font-medium 
                                   rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 
                                   focus:ring-indigo-500">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>