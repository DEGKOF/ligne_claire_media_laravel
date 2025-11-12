// public/js/soutient.js

// Variable pour stocker le montant de base
let baseAmount = 0;

// Fonction pour calculer le montant total selon la fréquence
function calculateTotalAmount() {
    const amountInput = document.getElementById('amount-input-don');
    const frequencySelect = document.getElementById('frequency-select-don');

    if (!amountInput || !frequencySelect) return;

    const frequency = frequencySelect.value;
    const amount = parseInt(amountInput.value) || 0;

    // Si le montant vient d'être modifié, on met à jour le montant de base
    if (amount !== baseAmount * getMultiplier(frequency)) {
        baseAmount = amount;
    }

    let totalAmount = baseAmount;
    let multiplier = 1;
    let periodText = '';

    switch (frequency) {
        case 'ponctuel':
            multiplier = 1;
            periodText = 'Paiement unique';
            break;
        case 'mensuel':
            multiplier = 1;
            periodText = 'par mois';
            break;
        case 'trimestriel':
            multiplier = 3;
            periodText = 'tous les 3 mois';
            break;
        case 'semestriel':
            multiplier = 6;
            periodText = 'tous les 6 mois';
            break;
        case 'annuel':
            multiplier = 12;
            periodText = 'par an';
            break;
    }

    totalAmount = baseAmount * multiplier;

    // Mettre à jour l'affichage du montant
    updateAmountDisplay(totalAmount, periodText, multiplier, frequency);

    // Mettre à jour la valeur de l'input si ce n'est pas un paiement ponctuel
    if (frequency !== 'ponctuel') {
        amountInput.value = totalAmount;
    }
}

// Fonction helper pour obtenir le multiplicateur
function getMultiplier(frequency) {
    const multipliers = {
        'ponctuel': 1,
        'mensuel': 1,
        'trimestriel': 3,
        'semestriel': 6,
        'annuel': 12
    };
    return multipliers[frequency] || 1;
}

// Fonction pour mettre à jour l'affichage du montant
function updateAmountDisplay(totalAmount, periodText, multiplier, frequency) {
    // Supprimer l'ancien affichage s'il existe
    const oldDisplay = document.getElementById('amount-display');
    if (oldDisplay) {
        oldDisplay.remove();
    }

    // Créer un nouvel affichage
    const amountInput = document.getElementById('amount-input-don');
    const formGroup = amountInput.closest('.form-group');

    const displayDiv = document.createElement('div');
    displayDiv.id = 'amount-display';
    displayDiv.style.cssText = `
        margin-top: 10px;
        padding: 15px;
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-radius: 8px;
        border-left: 4px solid #1565C0;
        font-weight: 600;
        color: #0D47A1;
    `;

    if (frequency === 'ponctuel') {
        displayDiv.innerHTML = `
            <div style="font-size: 1.1rem;">
                💰 Montant à payer : <strong>${totalAmount.toLocaleString('fr-FR')} FCFA</strong>
            </div>
            <div style="font-size: 0.9rem; margin-top: 5px; color: #1565C0;">
                ${periodText}
            </div>
        `;
    } else {
        displayDiv.innerHTML = `
            <div style="font-size: 0.95rem; margin-bottom: 8px;">
                Montant mensuel : <strong>${baseAmount.toLocaleString('fr-FR')} FCFA</strong>
            </div>
            <div style="font-size: 1.1rem; border-top: 2px solid #1565C0; padding-top: 8px;">
                💰 Total à payer : <strong>${totalAmount.toLocaleString('fr-FR')} FCFA</strong>
            </div>
            <div style="font-size: 0.9rem; margin-top: 5px; color: #1565C0;">
                ${periodText} (${baseAmount.toLocaleString('fr-FR')} × ${multiplier})
            </div>
        `;
    }

    formGroup.appendChild(displayDiv);
}

// Fonction pour gérer le montant pré-rempli
function handlePrefilledAmount() {
    const amountInput = document.getElementById('amount-input-don');
    if (amountInput && amountInput.value) {
        // Initialiser baseAmount avec la valeur pré-remplie
        baseAmount = parseInt(amountInput.value) || 0;

        // Trouver et activer le bouton correspondant
        const matchingBtn = document.querySelector(`.amount-btn[data-amount="${amountInput.value}"]`);
        if (matchingBtn) {
            document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
            matchingBtn.classList.add('active');
        } else {
            // Si montant personnalisé, activer le bouton "Montant libre"
            const customBtn = document.querySelector('.amount-btn[data-amount="custom"]');
            if (customBtn) {
                document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
                customBtn.classList.add('active');
            }
        }

        // Calculer et afficher le montant
        calculateTotalAmount();

        // Ouvrir le modal de don automatiquement
        showPaymentForm('don');
    }
}

// Affichage/masquage des formulaires de paiement en modal
function showPaymentForm(type) {
    // Fermer tous les modals
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.classList.remove('active');
        const form = overlay.querySelector('.payment-form');
        if (form) form.classList.remove('active');
    });

    // Ouvrir le modal demandé
    const modalOverlay = document.getElementById(`modal-overlay-${type}`);
    const form = document.getElementById(`payment-form-${type}`);

    if (modalOverlay && form) {
        modalOverlay.classList.add('active');
        form.classList.add('active');
        // Empêcher le scroll du body
        document.body.style.overflow = 'hidden';
    }
}

// Fonction pour fermer le modal
function closePaymentForm(type) {
    const modalOverlay = document.getElementById(`modal-overlay-${type}`);
    const form = document.getElementById(`payment-form-${type}`);

    if (modalOverlay && form) {
        modalOverlay.classList.remove('active');
        form.classList.remove('active');
        // Réactiver le scroll du body
        document.body.style.overflow = '';
    }
}

// Fonction pour scroll vers une carte spécifique (conservée pour compatibilité)
function scrollToCard(type) {
    const card = document.querySelector(`.support-card:has(#payment-form-${type})`);
    if (card) {
        card.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}

// Initialisation au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {

    // Fermer le modal en cliquant sur l'overlay
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                const type = this.id.replace('modal-overlay-', '');
                closePaymentForm(type);
            }
        });
    });

    // Fermer le modal avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(overlay => {
                const type = overlay.id.replace('modal-overlay-', '');
                closePaymentForm(type);
            });
        }
    });

    // Gestion des montants de don
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));

            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            const amount = this.dataset.amount;
            const amountInput = document.getElementById('amount-input-don');

            if (amount !== 'custom') {
                baseAmount = parseInt(amount);
                amountInput.value = amount;
                calculateTotalAmount();
            } else {
                amountInput.value = '';
                amountInput.focus();
                amountInput.placeholder = 'Entrez votre montant...';
                baseAmount = 0;
                // Supprimer l'affichage
                const oldDisplay = document.getElementById('amount-display');
                if (oldDisplay) oldDisplay.remove();
            }
        });
    });

    // Gestion des fréquences de don avec calcul automatique
    document.querySelectorAll('.frequency-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.frequency-btn').forEach(b => b.classList.remove('active'));

            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            const frequency = this.dataset.frequency;
            const frequencySelect = document.getElementById('frequency-select-don');

            if (frequencySelect) {
                frequencySelect.value = frequency;
                calculateTotalAmount();
            }
        });
    });

    // Écouter les changements manuels du montant
    const amountInput = document.getElementById('amount-input-don');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            const amount = parseInt(this.value) || 0;
            if (amount > 0) {
                baseAmount = amount;
                calculateTotalAmount();
            }
        });

        amountInput.addEventListener('blur', function() {
            calculateTotalAmount();
        });
    }

    // Écouter les changements du select de fréquence
    const frequencySelect = document.getElementById('frequency-select-don');
    if (frequencySelect) {
        frequencySelect.addEventListener('change', function() {
            // Mettre à jour le bouton actif
            const activeBtn = document.querySelector(`.frequency-btn[data-frequency="${this.value}"]`);
            if (activeBtn) {
                document.querySelectorAll('.frequency-btn').forEach(b => b.classList.remove('active'));
                activeBtn.classList.add('active');
            }
            calculateTotalAmount();
        });
    }

    // Validation personnalisée des formulaires
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Validation du montant pour le formulaire de don
            if (this.querySelector('#amount-input-don')) {
                const amount = parseInt(this.querySelector('#amount-input-don').value);

                if (isNaN(amount) || amount < 500) {
                    e.preventDefault();
                    alert('⚠️ Le montant minimum est de 500 FCFA');
                    return false;
                }
            }

            // Afficher un message de confirmation
            const submitBtn = this.querySelector('.submit-btn');
            if (submitBtn) {
                submitBtn.textContent = '⏳ Traitement en cours...';
                submitBtn.disabled = true;
            }
        });
    });

    // Animation au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    // Observer les cartes de support
    document.querySelectorAll('.support-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Message de bienvenue
    console.log('💝 Merci de visiter notre page de soutien !');
    console.log('🌟 Ensemble, construisons une presse libre et indépendante.');
});
