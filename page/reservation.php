<?php
 require_once("../admis/db.php");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>barber - Réservation</title>
    <meta name="description" content="Page de réservation alignée sur la table reservation : id_reservation, id_utilisateur, id_employe, date_reservation, heure_reservation, photo_du_style, ticket_en_pdf, date_de_creation.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- jsPDF CDN for client-side PDF Ticket Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="../css/reservation.css">
</head>
<body>
    <!-- avbar -->
    <header>
      <!--div class="logo">
         <img src="..\img\logo.png" alt="Logo de StyleConnect">
         <span>Barber & Coiffeuse</span>
       </div-->
    <nav class="navbar">
          <span class="menu-toggle"><i class="fas fa-bars"></i></span>
            <ul>
               <li><a href="#Acceuil"><i class="fas fa-home"></i>Acceuil</a></li>
               <li><a href="#Apropos"><i class="fas fa-info-circle"></i>À propos</a></li>
                <li><a href="#services"><i class="fas fa-cut"></i>Services</a></li>
                <li><a href="#Galerie"><i class="fas fa-images"></i>Galerie</a></li>
                <li><a href="formResev.html"><i class="fas fa-calendar-alt"></i>Reservation</a></li>
               <li><a href="connexion.php"><i class="fas fa-sign-in-alt"></i>Connexion</a></li>
            </ul>
         </nav>
    </header>
    <div class="container">
        <!-- Panel Mappage de la table reservation -->
        <!--div class="db-mapping-panel">
            <h3> Structure de la Table `reservation` détectée :</h3>
            <div class="schema-tags-grid">
                <div class="schema-col-tag"><code>id_reservation</code> : INT (PK)</div>
                <div class="schema-col-tag"><code>id_utilisateur</code> : INT (FK)</div>
                <div class="schema-col-tag"><code>id_employe</code> : INT (FK)</div>
                <div class="schema-col-tag"><code>date_reservation</code> : DATE</div>
                <div class="schema-col-tag"><code>heure_reservation</code> : TIME</div>
                <div class="schema-col-tag"><code>photo_du_style</code> : VARCHAR/URL</div>
                <div class="schema-col-tag"><code>ticket_en_pdf</code> : VARCHAR/PDF</div>
                <div class="schema-col-tag"><code>date_de_creation</code> : TIMESTAMP</div>
            </div>
        </div-->
        <div class="layout-grid">
            <!-- Formulaire de Réservation -->
            <main class="form-card">
                <div class="form-section-title">Formulaire de Réservation</div>
                <div class="form-section-sub">Remplissez les champs ci-dessous pour enregistrer la réservation et générer votre ticket PDF.</div>
                <form id="reservationForm" method="POST" action="../logique/reservation.php" onsubmit="processReservation(event)">
                    
                    <!-- Utilisateur (id_utilisateur) -->
                    <div class="form-group">
                        <label class="form-label">Nom Client</label>
                        <div class="form-row">
                            <input type="text" id="nom" name="nom" class="form-input" placeholder="Votre nom" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email Client</label>
                            <input type="email" id="email_client" name="email_client" class="form-input" required placeholder="moukaila@example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" id="tel_client" name="tel_client" class="form-input" required placeholder="71769907">
                        </div>
                    </div>
                    <!-- Employé (id_employe) -->
                    <div class="form-group">
                        <label class="form-label">Coiffeur / Barbier Désigné </label>
                        <select id="id_employe" name="id_employe" class="form-select" onchange="updateSummary()">
                            <?php
                            //recuperer les employes de la table employes
                            $ql = "SELECT id_employe, nom_employe FROM employes";
                            $stmt = $pdo->query($ql);
                            //les options de la liste déroulante
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $id_emp = $row['id_employe'];
                                $nom_emp = $row['nom_employe'];
                                echo "<option value=\"$id_emp\" data-name=\"$nom_emp\">$nom_emp</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Date & Heure (date_reservation & heure_reservation) -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Date du Rendez-vous </label>
                            <input type="date" id="date_reservation" name="date_reservation" class="form-input" required value="2026-09-15" onchange="updateSummary()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Heure du Rendez-vous </label>
                            <input type="time" id="heure_reservation_time" name="heure_reservation_time" class="form-input" onchange="updateSummary()" style="margin-top: 8px;">
                        </div>
                    </div>
                    <!-- Photo du Style (photo_du_style) -->
                    <div class="form-group">
                        <label class="form-label">Photo du Style Souhaité <code>photo_du_style</code></label>
                        
                        <div class="style-photo-picker" id="uploadDropZone" onclick="document.getElementById('fileInput').click();">
                            <div style="font-size: 1.8rem; margin-bottom: 6px;"><i class="fas fa-camera"></i></div>
                            <div style="font-weight: 700; font-size: 0.95rem;">Cliquez pour importer la photo de votre modèle / coupe</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">Formats acceptés: JPG, PNG (Max 5Mo)</div>
                            <input type="file" id="fileInput" accept="image/*" class="hidden" onchange="handleFileSelect(event)">
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 12px; font-weight: 700;">Ou choisissez parmi nos styles de référence :</div>
    
                    </div>
                    <button type="submit" class="btn-primary" name="submit" id="btnSubmit">
                        Valider la reservation 
                    </button>
                </form>
            </main>
            <!-- Sidebar Reçu / Pass PDF -->
            <!--aside class="ticket-pass-card">
                <div class="ticket-header">
                    <span>Pass Réservation</span>
                    <span class="ticket-code-tag" id="disp_id_res">#RES-8492</span>
                </div>
                <div class="ticket-row">
                    <span>ID Utilisateur :</span>
                    <strong id="disp_id_user">USR-104 (Thomas Martin)</strong>
                </div>
                <div class="ticket-row">
                    <span>ID Employé :</span>
                    <strong id="disp_id_emp">EMP-1 (Alexandre M.)</strong>
                </div>
                <div class="ticket-row">
                    <span>Date RDV :</span>
                    <strong id="disp_date">15/09/2026</strong>
                </div>
                <div class="ticket-row">
                    <span>Heure RDV :</span>
                    <strong id="disp_heure">11:15</strong>
                </div>
                <div class="ticket-row">
                    <span>Date Création :</span>
                    <strong id="disp_created" style="font-family: var(--font-mono); font-size: 0.8rem;">2026-09-14 22:18</strong>
                </div>
                <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-top: 4px;">Photo du Style Référence (<code>photo_du_style</code>) :</div>
                <div class="ticket-photo-thumb">
                    <img id="disp_photo_style" src="assets/barber_lookbook_gallery_1788785679953.jpg" alt="Aperçu photo style">
                </div>
                <div class="barcode-visual">
                    <div class="barcode-lines"></div>
                    <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #333; margin-top: 4px;" id="disp_barcode">RES-8492-2026</div>
                </div>
                <div id="pdfDownloadSection" class="hidden">
                    <div style="background: rgba(16, 185, 129, 0.15); color: var(--accent-green); border: 1px solid var(--accent-green); border-radius: var(--radius-md); padding: 12px; text-align: center; font-size: 0.85rem; font-weight: 700; margin-bottom: 10px;">
                        ✓ Réservation enregistrée en BDD !
                    </div>
                    <button class="btn-download-pdf" onclick="generateAndDownloadPDF()">
                        📥 Télécharger le Ticket (<code>ticket_en_pdf</code>)
                    </button>
                </div>
            </aside>
        </div>
    </div>
    <script>
        let currentPhotoUrl = 'assets/barber_lookbook_gallery_1788785679953.jpg';
        let generatedReservationCode = '#RES-8492';
        let generatedPdfPath = '/tickets/ticket_res_8492.pdf';
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentPhotoUrl = e.target.result;
                    document.getElementById('disp_photo_style').src = currentPhotoUrl;
                };
                reader.readAsDataURL(file);
            }
        }
        function selectSamplePhoto(url, thumbElement) {
            document.querySelectorAll('.sample-photo-thumb').forEach(t => t.classList.remove('selected'));
            thumbElement.classList.add('selected');
            currentPhotoUrl = url;
            document.getElementById('disp_photo_style').src = url;
        }
        function updateSummary() {
            const empSelect = document.getElementById('id_employe');
            const empName = empSelect.options[empSelect.selectedIndex].getAttribute('data-name');
            const empId = empSelect.value;
            const dateVal = document.getElementById('date_reservation').value;
            const heureVal = document.getElementById('heure_reservation_time').value;
            document.getElementById('disp_id_emp').textContent = `EMP-${empId} (${empName.split(' ')[0]})`;
            document.getElementById('disp_date').textContent = dateVal;
            document.getElementById('disp_heure').textContent = heureVal;
        }
        function processReservation(event) {
            if (event) {
                event.preventDefault();
            }

            const nom = document.getElementById('nom').value.trim();
            const email = document.getElementById('email_client').value.trim();
            const tel = document.getElementById('tel_client').value.trim();
            const empId = document.getElementById('id_employe').value;
            const dateVal = document.getElementById('date_reservation').value;
            const heureVal = document.getElementById('heure_reservation_time').value;

            if (!nom || !email || !tel || !dateVal || !heureVal) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }

            const randomCode = 'RES-' + Math.floor(1000 + Math.random() * 9000);
            generatedReservationCode = '#' + randomCode;
            generatedPdfPath = `/tickets/ticket_${randomCode.toLowerCase()}.pdf`;
            document.getElementById('disp_id_res').textContent = generatedReservationCode;
            document.getElementById('disp_id_user').textContent = `USR-${Math.floor(100 + Math.random() * 900)} (${nom})`;
            document.getElementById('disp_barcode').textContent = `${randomCode}-2026`;

            const now = new Date();
            const timestampStr = now.toISOString().replace('T', ' ').substring(0, 16);
            document.getElementById('disp_created').textContent = timestampStr;
            document.getElementById('pdfDownloadSection').classList.remove('hidden');

            const form = document.getElementById('reservationForm');
            const formData = new FormData(form);

            fetch('../logique/reservation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result || 'Réservation enregistrée avec succès !');
            })
            .catch(error => {
                console.error(error);
                alert('Une erreur est survenue lors de l\'enregistrement de la réservation.');
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        function generateAndDownloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const resCode = document.getElementById('disp_id_res').textContent;
            const clientName = document.getElementById('nom').value.trim();
            const empSelect = document.getElementById('id_employe');
            const empName = empSelect.options[empSelect.selectedIndex].getAttribute('data-name');
            const dateVal = document.getElementById('date_reservation').value;
            const heureVal = document.getElementById('heure_reservation_time').value;
            const createdAt = document.getElementById('disp_created').textContent;
            // PDF Styling
            doc.setFillColor(11, 15, 23);
            doc.rect(0, 0, 210, 40, 'F');
            doc.setTextColor(245, 158, 11);
            doc.setFontSize(20);
            doc.setFont("helvetica", "bold");
            doc.text("L'ATELIER - TICKET DE RÉSERVATION", 15, 25);
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(10);
            doc.text(`CODE : ${resCode}`, 155, 25);
            doc.setTextColor(30, 41, 59);
            doc.setFontSize(12);
            let y = 55;
            doc.setFont("helvetica", "bold");
            doc.text("DÉTAILS ENREGISTRÉS DANS LA TABLE RESERVATION :", 15, y);
            
            y += 12;
            doc.setFont("helvetica", "normal");
            doc.text(`• ID Réservation : ${resCode}`, 20, y);
            y += 10;
            doc.text(`• Client (id_utilisateur) : ${clientName}`, 20, y);
            y += 10;
            doc.text(`• Coiffeur / Barbier (id_employe) : ${empName}`, 20, y);
            y += 10;
            doc.text(`• Date de réservation (date_reservation) : ${dateVal}`, 20, y);
            y += 10;
            doc.text(`• Heure de réservation (heure_reservation) : ${heureVal}`, 20, y);
            y += 10;
            doc.text(`• Photo du style (photo_du_style) : ${currentPhotoUrl}`, 20, y);
            y += 10;
            doc.text(`• Fichier PDF (ticket_en_pdf) : ${generatedPdfPath}`, 20, y);
            y += 10;
            doc.text(`• Date de création (date_de_creation) : ${createdAt}`, 20, y);
            y += 20;
            doc.setDrawColor(245, 158, 11);
            doc.setLineWidth(1);
            doc.line(15, y, 195, y);
            y += 15;
            doc.setFontSize(10);
            doc.setTextColor(100, 116, 139);
            doc.text("Présentez ce ticket lors de votre arrivée au salon (14 Rue Saint-Honoré, Paris).", 15, y);
            // Save PDF File
            doc.save(`Ticket_Reservation_${resCode.replace('#', '')}.pdf`);
        }
    </script>
</body>
</html>
