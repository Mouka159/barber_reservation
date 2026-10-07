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
                    <!--div class="form-group">
                        <label class="form-label">Pseudo</label>
                        <div class="form-row">
                           
                        </div>
                        <div class="form-row">
                           <label class="form-label">service</label>
                            
                            </div>
                    </div-->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Pseudo</label>
                             <input type="text" id="nom" name="nom_client" class="form-input" placeholder="Votre nom" required oninput="updateSummary()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Service</label>
                            <select id="id_service" name="id_service" class="form-input" value="selectionner votre services" required onchange="updateSummary()">
                                <?php
                                // Récupérer les services de la table services
                                $sql = "SELECT id_service, nom_service FROM services";
                                $stmt = $pdo->query($sql);
                                // Les options de la liste déroulante
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $id_serv = $row['id_service'];
                                    $nom_serv = $row['nom_service'];
                                    echo "<option value=\"$id_serv\">$nom_serv</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email Client</label>
                            <input type="email" id="email_client" name="email_client" class="form-input" required placeholder="moukaila@example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" id="tel_client" name="tel_client" class="form-input" required placeholder="71769907" oninput="updateSummary()">
                        </div>
                    </div>
                    <!-- Employé (id_employe) -->
                    <div class="form-group">
                        <label class="form-label">Coiffeur / Barbier Désigné </label>
                        <select id="id_employe" name="id_employe" class="form-select" placeholder="Sélectionnez un employé" onchange="updateSummary()">
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
                            <input type="date" id="date_reservation" name="date_reservation" class="form-input" required onchange="updateSummary()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Heure du Rendez-vous </label>
                            <input type="time" id="heure_reservation_time" name="heure_reservation_time" class="form-input" onchange="updateSummary()" style="margin-top: 8px;">
                        </div>
                    </div>
                    <!-- Photo du Style (photo_du_style) -->
                    <div class="form-group">
                        <label class="form-label">Photo du Style Souhaité </label>
                        
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
            <aside class="ticket-pass-card">
                <div class="ticket-header">
                    <span>Pass Réservation</span>
                    <span class="ticket-code-tag" id="disp_id_res">#RES-8492</span>
                </div>
                <div class="ticket-row">
                    <span>pseudo_client :</span>
                    <strong id="disp_id_user"></strong>
                </div>
                <div class="ticket-row">
                    <span>Prenom emp</span>
                    <strong id="disp_id_emp"></strong>
                </div>
                <div class="ticket-row">
                    <span>Service :</span>
                    <strong id="disp_id_service"></strong>
                </div>
                <div class="ticket-row">
                    <span>Date RDV :</span>
                    <strong id="disp_date"></strong>
                </div>
                <div class="ticket-row">
                    <span>Heure RDV :</span>
                    <strong id="disp_heure"></strong>
                </div>
                <div class="ticket-row">
                    <span>Date /heure  :</span>
                    <strong id="disp_created" style="font-family: var(--font-mono); font-size: 0.8rem;"></strong>
                </div>
                <div class="ticket-row">
                    <span>Numéro de téléphone :</span>
                    <strong id="disp_tel_client"></strong>
                </div>
                <div style="font-size: 0.85rem; font-weight: 900;  color: var(--text-muted);  margin-top: 4px;">Photo du Style Référence:</div>
                <div class="ticket-photo-thumb">
                    <img id="disp_photo_style" src="assets/barber_lookbook_gallery_1788785679953.jpg" style="" alt="Aperçu photo style">
                </div>
                
                <!--code qr-->
                </div>
            </aside>
        </div>
    </div>
    <script src="../js/reservation.js"></script>
</body>
</html>
