(function() {
    'use strict';

    // Configuration
    const PUBLICATION_SLUG = document.querySelector('meta[name="publication-slug"]')?.content || window.location.pathname.split('/').pop();
    let currentPage = 1;
    let isAuthenticated = false;
    let userData = {};
    let isSubmitting = false;

    console.log('Publication slug:', PUBLICATION_SLUG);

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing comments...');
        checkUserAuthentication();
        loadComments(1);
        initializeCommentForm();
        initializeCharacterCounter();
    });

    // Vérifier si l'utilisateur est connecté
    async function checkUserAuthentication() {
        try {
            const response = await fetch('/api/user/info');
            const data = await response.json();

            console.log('User auth data:', data);

            isAuthenticated = data.authenticated;

            if (isAuthenticated) {
                userData = data.user;
                hideGuestFields();
            } else {
                showGuestFields();
            }
        } catch (error) {
            console.error('Erreur lors de la vérification de l\'authentification:', error);
            showGuestFields();
        }
    }

    // Masquer les champs invité
    function hideGuestFields() {
        const guestFields = document.getElementById('guest-fields');
        if (guestFields) {
            guestFields.classList.add('hidden');
        }
    }

    // Afficher les champs invité
    function showGuestFields() {
        const guestFields = document.getElementById('guest-fields');
        if (guestFields) {
            guestFields.classList.remove('hidden');
        }
    }

    // Charger les commentaires
    async function loadComments(page = 1) {
        try {
            console.log('Loading comments for page:', page);
            const response = await fetch(`/api/publications/${PUBLICATION_SLUG}/comments?page=${page}`);
            const data = await response.json();

            console.log('Comments data received:', data);

            if (data.success) {
                displayComments(data.comments);
                displayPagination(data.pagination);
                currentPage = page;
            }
        } catch (error) {
            console.error('Erreur lors du chargement des commentaires:', error);
            document.getElementById('comments-list').innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <p>Impossible de charger les commentaires.</p>
                </div>
            `;
        }
    }

    // Échapper le HTML pour éviter les XSS
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Afficher les commentaires
    function displayComments(comments) {
        const commentsList = document.getElementById('comments-list');

        console.log('Displaying comments:', comments);

        if (!comments || comments.length === 0) {
            commentsList.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <p class="text-lg">💭 Aucun commentaire pour le moment.</p>
                    <p class="text-sm mt-2">Soyez le premier à partager votre avis !</p>
                </div>
            `;
            return;
        }

        commentsList.innerHTML = comments.map(comment => {
            console.log('Processing comment:', comment);
            return `
            <div class="flex gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg">
                        ${escapeHtml(comment.author_initials || 'AN')}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-bold text-gray-900">${escapeHtml(comment.author_name || 'Anonyme')}</span>
                        <span class="text-sm text-gray-500">${escapeHtml(comment.time_ago || '')}</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">${escapeHtml(comment.content || '')}</p>
                </div>
            </div>
        `}).join('');
    }

    // Afficher la pagination
    function displayPagination(pagination) {
        const paginationContainer = document.getElementById('comments-pagination');

        if (!pagination || pagination.last_page <= 1) {
            paginationContainer.classList.add('hidden');
            return;
        }

        paginationContainer.classList.remove('hidden');

        let paginationHTML = '<div class="flex gap-2">';

        if (pagination.current_page > 1) {
            paginationHTML += `
                <button onclick="window.loadCommentsPage(${pagination.current_page - 1})"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
                    ← Précédent
                </button>
            `;
        }

        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === pagination.current_page) {
                paginationHTML += `
                    <button class="px-4 py-2 bg-blue-600 text-white rounded font-bold">
                        ${i}
                    </button>
                `;
            } else {
                paginationHTML += `
                    <button onclick="window.loadCommentsPage(${i})"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
                        ${i}
                    </button>
                `;
            }
        }

        if (pagination.current_page < pagination.last_page) {
            paginationHTML += `
                <button onclick="window.loadCommentsPage(${pagination.current_page + 1})"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
                    Suivant →
                </button>
            `;
        }

        paginationHTML += '</div>';
        paginationContainer.innerHTML = paginationHTML;
    }

    window.loadCommentsPage = loadComments;

    // Initialiser le formulaire de commentaire
    function initializeCommentForm() {
        const form = document.getElementById('comment-form');

        if (!form) {
            console.error('Form not found!');
            return;
        }

        // Retirer tous les anciens listeners
        const newForm = form.cloneNode(true);
        form.parentNode.replaceChild(newForm, form);

        newForm.addEventListener('submit', handleFormSubmit);
    }

    async function handleFormSubmit(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Form submitted, isSubmitting:', isSubmitting);

        if (isSubmitting) {
            console.log('Already submitting, ignoring...');
            return false;
        }

        isSubmitting = true;

        clearErrors();
        hideMessages();

        const formData = new FormData(e.target);
        const data = {
            content: formData.get('content'),
        };

        if (!isAuthenticated) {
            data.guest_name = formData.get('guest_name');
            data.guest_email = formData.get('guest_email');
        }

        console.log('Sending data:', data);

        showLoading();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token');

            const response = await fetch(`/api/publications/${PUBLICATION_SLUG}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            console.log('Response:', result);

            if (result.success) {
                showSuccessMessage();
                e.target.reset();
                updateCharCount(0);

                await loadComments(1);

                const countElement = document.getElementById('comments-count');
                if (countElement) {
                    countElement.textContent = parseInt(countElement.textContent) + 1;
                }

                setTimeout(() => {
                    document.getElementById('comments-list')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 500);
            } else {
                if (result.errors) {
                    displayErrors(result.errors);
                } else {
                    showErrorMessage(result.message || 'Une erreur est survenue');
                }
            }
        } catch (error) {
            console.error('Erreur lors de l\'envoi du commentaire:', error);
            showErrorMessage('Impossible d\'envoyer le commentaire. Veuillez réessayer.');
        } finally {
            hideLoading();
            setTimeout(() => {
                isSubmitting = false;
                console.log('Reset isSubmitting to false');
            }, 1000);
        }

        return false;
    }

    function initializeCharacterCounter() {
        const contentTextarea = document.getElementById('content');

        if (!contentTextarea) return;

        contentTextarea.addEventListener('input', function() {
            updateCharCount(this.value.length);
        });
    }

    function updateCharCount(count) {
        const charCountElement = document.getElementById('char-count');
        if (!charCountElement) return;

        charCountElement.textContent = `${count} / 1000`;

        if (count > 1000) {
            charCountElement.classList.add('text-red-500');
            charCountElement.classList.remove('text-gray-500');
        } else {
            charCountElement.classList.remove('text-red-500');
            charCountElement.classList.add('text-gray-500');
        }
    }

    function showLoading() {
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        if (submitBtn) submitBtn.disabled = true;
        if (submitText) submitText.classList.add('hidden');
        if (submitLoading) submitLoading.classList.remove('hidden');
    }

    function hideLoading() {
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        if (submitBtn) submitBtn.disabled = false;
        if (submitText) submitText.classList.remove('hidden');
        if (submitLoading) submitLoading.classList.add('hidden');
    }

    function showSuccessMessage() {
        const successMessage = document.getElementById('success-message');
        if (!successMessage) return;

        successMessage.classList.remove('hidden');

        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 5000);
    }

    function showErrorMessage(message) {
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');

        if (!errorMessage || !errorText) return;

        errorText.textContent = message;
        errorMessage.classList.remove('hidden');

        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, 5000);
    }

    function hideMessages() {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        if (successMessage) successMessage.classList.add('hidden');
        if (errorMessage) errorMessage.classList.add('hidden');
    }

    function displayErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const errorElement = document.getElementById(`error-${field}`);
            if (errorElement && messages && messages.length > 0) {
                errorElement.textContent = messages[0];
                errorElement.classList.remove('hidden');
            }
        }
    }

    function clearErrors() {
        const errorElements = document.querySelectorAll('[id^="error-"]');
        errorElements.forEach(element => {
            element.textContent = '';
            element.classList.add('hidden');
        });
    }

})();
