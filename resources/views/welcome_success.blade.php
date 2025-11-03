<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Paiement réussi — Récapitulatif</title>
  <style>
    :root{--bg:#f6f9fc;--card:#ffffff;--accent:#16a34a;--muted:#6b7280;--glass:rgba(0,0,0,0.04)}
    *{box-sizing:border-box}
    body{font-family:Inter,ui-sans-serif,system-ui,Segoe UI,Roboto,"Helvetica Neue",Arial; margin:0; background:linear-gradient(180deg, #f8fafc, var(--bg)); color:#0f172a}
    .container{max-width:900px;margin:40px auto;padding:24px}
    .card{background:var(--card);border-radius:12px;padding:24px;box-shadow:0 6px 24px var(--glass);}
    .header{display:flex;gap:16px;align-items:center}
    .badge{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#ddf7e6,#c7f0d8)}
    .badge svg{width:40px;height:40px;fill:var(--accent)}
    h1{font-size:20px;margin:0}
    p.lead{margin:4px 0 0;color:var(--muted)}

    .grid{display:grid;grid-template-columns:1fr 320px;gap:20px;margin-top:20px}
    .order-summary{background:#fbfdff;padding:18px;border-radius:10px}
    .meta{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed #eef2f7}
    .meta:last-child{border-bottom:0}
    .muted{color:var(--muted);font-size:13px}

    .items{margin-top:12px}
    .item{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f1f5f9}
    .item:last-child{border-bottom:0}
    .total{display:flex;justify-content:space-between;font-weight:700;padding-top:12px}

    .actions{display:flex;gap:10px;margin-top:18px}
    .btn{padding:10px 14px;border-radius:8px;border:0;font-weight:600;cursor:pointer}
    .btn-primary{background:var(--accent);color:#fff}
    .btn-ghost{background:transparent;border:1px solid #e6eef4;color:#0f172a}

    .receipt{font-size:13px;color:var(--muted);margin-top:8px}

    @media (max-width:820px){.grid{grid-template-columns:1fr;}.badge{width:56px;height:56px}.header{gap:12px}}
  </style>
</head>
<body>
  <main class="container">
    <section class="card" role="region" aria-labelledby="title">
      <div class="header">
        <div class="badge" aria-hidden>
          <!-- check icon -->
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden>
            <path d="M9.00039 16.2L4.80039 12.0L3.40039 13.4L9.00039 19.0L21.0004 7.0L19.6004 5.6L9.00039 16.2Z"/>
          </svg>
        </div>
        <div>
          <h1 id="title">Paiement confirmé — merci !</h1>
          <p class="lead">Votre paiement a été traité avec succès. Ci‑dessous le récapitulatif de la transaction.</p>
        </div>
      </div>

      <div class="grid">
        <div>
          <div class="order-summary">
            <div class="meta"><div class="muted">Client</div><div><strong>Jean Dupont (fictif)</strong></div></div>
            <div class="meta"><div class="muted">Référence transaction</div><div><strong>#TXN-2025-09-0157</strong></div></div>
            <div class="meta"><div class="muted">Date</div><div><strong>29 octobre 2025 — 13:05</strong></div></div>
            <div class="meta"><div class="muted">Moyen de paiement</div><div><strong>Carte bancaire • Visa</strong></div></div>

            <div class="items">
              <div class="muted">Articles</div>
              <div class="item"><div>Abonnement Pro — 1 mois</div><div>30,00 €</div></div>
              <div class="item"><div>Pack crédits — 500 coins</div><div>12,50 €</div></div>
              <div class="item"><div>Remise</div><div>-3,00 €</div></div>
              <div class="total"><div>Total payé</div><div>39,50 €</div></div>
            </div>

            <div class="receipt">ID paiement: <strong>pay_64f9c2b1f3a2</strong> • Autorisation: <strong>AUTH-88211</strong></div>

            <div class="actions">
              <button class="btn btn-primary" id="downloadReceipt">Télécharger le reçu</button>
              <button class="btn btn-ghost" id="printPage">Imprimer</button>
              <button class="btn btn-ghost" id="goDashboard">Aller au tableau de bord</button>
            </div>
          </div>

          <div style="margin-top:14px;color:var(--muted);font-size:13px">
            <strong>Note :</strong> Ceci est un exemple avec des données fictives. Pour un usage réel, chargez ici les vraies données retournées par votre passerelle de paiement (ID, montant, statut, QR/URL du reçu...).
          </div>
        </div>

        <aside class="card" style="background:#fbfffb;align-self:start">
          <h2 style="margin:0 0 8px 0;font-size:16px">Détails de facturation</h2>
          <div class="muted">Nom</div>
          <div style="margin-bottom:10px"><strong>Jean Dupont</strong></div>

          <div class="muted">Email</div>
          <div style="margin-bottom:10px"><strong>jean.dupont@example.com</strong></div>

          <div class="muted">Adresse</div>
          <div style="margin-bottom:10px">12 rue Imaginaire, 75001 Paris, France</div>

          <div style="border-top:1px dashed #eef2f7;padding-top:12px;margin-top:8px">
            <div class="muted">Statut</div>
            <div style="color:var(--accent);font-weight:700;margin-top:6px">Succès</div>
            <div class="receipt" style="margin-top:8px">Reçu disponible pendant 30 jours (exemple).</div>
          </div>
        </aside>
      </div>
    </section>
  </main>

  <script>
    // Petit script d'exemple pour générer un reçu PDF/texte fictif
    document.getElementById('downloadReceipt').addEventListener('click', function(){
      const receipt = `Reçu de paiement\n\nClient: Jean Dupont\nRéférence: #TXN-2025-09-0157\nMontant: 39,50 €\nDate: 29/10/2025 13:05\nMoyen: Carte Visa\nID paiement: pay_64f9c2b1f3a2\nAutorisation: AUTH-88211\n\n--- Ceci est un reçu fictif ---`;
      const blob = new Blob([receipt], {type: 'text/plain'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'recu-paiement-TXN-2025-09-0157.txt';
      document.body.appendChild(a);
      a.click();
      a.remove();
      URL.revokeObjectURL(url);
    });

    document.getElementById('printPage').addEventListener('click', function(){ window.print(); });
    document.getElementById('goDashboard').addEventListener('click', function(){ window.location.href = '/'; });
  </script>
</body>
</html>
