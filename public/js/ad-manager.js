/**
 * Gestionnaire de publicités pour le frontend
 * Usage: <div id="ad-sidebar" data-position="sidebar"></div>
 */

class AdManager {
    constructor() {
        this.containers = document.querySelectorAll('[data-ad-position]');
        this.trackedImpressions = new Set();
        this.init();
    }

    init() {
        this.containers.forEach(container => {
            const position = container.dataset.adPosition;
            this.loadAds(position, container);
        });
    }

    async loadAds(position, container) {
        try {
            const response = await fetch(`/ads/get?position=${position}`);
            const ads = await response.json();

            if (ads && ads.length > 0) {
                const ad = ads[0]; // Prendre la première publicité
                this.renderAd(ad, container);
                this.trackImpression(ad.id);
            }
        } catch (error) {
            console.error('Erreur chargement publicité:', error);
        }
    }

    renderAd(ad, container) {
        let html = '';

        switch (ad.type) {
            case 'image':
                html = `
                    <div class="advertisement" data-ad-id="${ad.id}">
                        <div class="ad-label">Publicité</div>
                        <a href="#" onclick="adManager.handleClick(${ad.id}, '${ad.link_url}'); return false;">
                            <img src="${ad.image_url}" alt="${ad.title}" class="img-fluid">
                        </a>
                    </div>
                `;
                break;

            case 'video':
                html = `
                    <div class="advertisement" data-ad-id="${ad.id}">
                        <div class="ad-label">Publicité</div>
                        <video controls class="w-100" onclick="adManager.trackImpression(${ad.id})">
                            <source src="${ad.video_url}" type="video/mp4">
                        </video>
                        ${ad.link_url ? `
                            <a href="#" class="btn btn-primary mt-2"
                               onclick="adManager.handleClick(${ad.id}, '${ad.link_url}'); return false;">
                                En savoir plus
                            </a>
                        ` : ''}
                    </div>
                `;
                break;

            case 'text':
                html = `
                    <div class="advertisement text-ad" data-ad-id="${ad.id}">
                        <div class="ad-label">Publicité</div>
                        <div class="ad-content">${ad.content}</div>
                        ${ad.link_url ? `
                            <a href="#" class="btn btn-sm btn-outline-primary mt-2"
                               onclick="adManager.handleClick(${ad.id}, '${ad.link_url}'); return false;">
                                Voir plus
                            </a>
                        ` : ''}
                    </div>
                `;
                break;

            case 'mixed':
                html = `
                    <div class="advertisement" data-ad-id="${ad.id}">
                        <div class="ad-label">Publicité</div>
                        ${ad.image_url ? `<img src="${ad.image_url}" alt="${ad.title}" class="img-fluid mb-2">` : ''}
                        <div class="ad-content">${ad.content}</div>
                        ${ad.link_url ? `
                            <a href="#" class="btn btn-primary mt-2"
                               onclick="adManager.handleClick(${ad.id}, '${ad.link_url}'); return false;">
                                En savoir plus
                            </a>
                        ` : ''}
                    </div>
                `;
                break;
        }

        container.innerHTML = html;
    }

    async trackImpression(adId) {
        if (this.trackedImpressions.has(adId)) return;

        try {
            await fetch(`/ads/${adId}/impression`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });

            this.trackedImpressions.add(adId);
        } catch (error) {
            console.error('Erreur tracking impression:', error);
        }
    }

    async handleClick(adId, linkUrl) {
        try {
            const response = await fetch(`/ads/${adId}/click`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.url) {
                window.open(data.url, '_blank');
            }
        } catch (error) {
            console.error('Erreur tracking clic:', error);
        }
    }
}

// Initialiser automatiquement au chargement
let adManager;
document.addEventListener('DOMContentLoaded', () => {
    adManager = new AdManager();
});
