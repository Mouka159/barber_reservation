
        // ------------------------------------------------------------
        // VARIABLES GLOBALES DU FORMULAIRE DE RÉSERVATION
        // ------------------------------------------------------------
        // Stocke l'URL de la photo sélectionnée pour l'afficher dans le ticket
        let currentPhotoUrl = 'assets/barber_lookbook_gallery_1788785679953.jpg';
        // Code temporaire généré pour identifier la réservation dans le rendu visuel
        let generatedReservationCode = '#RES-8492';
        // Chemin de fichier du PDF qui sera associé à la réservation
        let generatedPdfPath = '/tickets/ticket_res_8492.pdf';
        let d=new Date();
        let jour=["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];
        let mois=["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
        //------------------------------------------------------------
        // date et heure actuelle pour l'affichage du ticket
        //------------------------------------------------------------
        let dateActuelle = `${jour[d.getDay()]} ${d.getDate()} ${mois[d.getMonth()]} ${d.getFullYear()} à ${d.getHours().toString().padStart(2, '0')}:${d.getMinutes().toString().padStart(2, '0')}`;
        document.getElementById('disp_created').textContent = dateActuelle;
        // ------------------------------------------------------------
        // 1) GESTION DE LA PHOTO IMPORTÉE PAR L'UTILISATEUR
        // ------------------------------------------------------------
        function handleFileSelect(event) {
            // Récupère le fichier choisi dans l'input type="file"
            const file = event.target.files[0];

            // Vérifie qu'un fichier a bien été sélectionné
            if (file) {
                // Lit le fichier comme une URL encodée pour l'afficher dans l'image
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentPhotoUrl = e.target.result;
                    document.getElementById('disp_photo_style').src = currentPhotoUrl;
                };
                reader.readAsDataURL(file);
            }
        }

        // ------------------------------------------------------------
        // 2) SÉLECTION D'UNE PHOTO DE RÉFÉRENCE PARMI LES STYLES
        // ------------------------------------------------------------
        function selectSamplePhoto(url, thumbElement) {
            // Retire la classe "selected" de toutes les miniatures pour garder un seul style actif
            document.querySelectorAll('.sample-photo-thumb').forEach(t => t.classList.remove('selected'));
            thumbElement.classList.add('selected');
            currentPhotoUrl = url;
            document.getElementById('disp_photo_style').src = url;
        }

        // ------------------------------------------------------------
        // 3) MISE À JOUR DU RÉCAPITULATIF DU TICKET
        // ------------------------------------------------------------
        function updateSummary() {
            // Récupère le coiffeur sélectionné dans le menu déroulant
            const empSelect = document.getElementById('id_employe');
            const empName = empSelect.options[empSelect.selectedIndex].getAttribute('data-name');
            const empId = empSelect.value;

            // Récupère la date et l'heure saisies par l'utilisateur
            const dateVal = document.getElementById('date_reservation').value;
            const heureVal = document.getElementById('heure_reservation_time').value;
            const serviceSelect = document.getElementById('id_service');

            // Met à jour le panneau latéral "Pass Réservation"
            document.getElementById('disp_id_user').textContent = document.getElementById('nom').value.trim();
            document.getElementById('disp_id_emp').textContent = `EMP-${empId} (${empName.split(' ')[0]})`;
            document.getElementById('disp_date').textContent = dateVal;
            document.getElementById('disp_heure').textContent = heureVal;
            document.getElementById('disp_tel_client').textContent = document.getElementById('tel_user').value.trim();
            document.getElementById('disp_id_service').textContent = serviceSelect.options[serviceSelect.selectedIndex].text;
            document.getElementById('disp_photo_style').alt = 'Photo du Style Souhaité';
        }

        // Affiche immédiatement les valeurs déjà présentes lors du chargement de la page
        updateSummary();


        // ------------------------------------------------------------
        // 4) VALIDATION ET ENVOI DE LA RÉSERVATION VERS PHP
        // ------------------------------------------------------------
        /*function processReservation(event) {
            // Empêche l'envoi du formulaire HTML classique pour gérer la requête en JavaScript
            if (event) {
                event.preventDefault();
            }

            // Récupère les valeurs du formulaire
            const nom = document.getElementById('disp_id_user').textContent.split(' ')[0].split('-')[1];
            const email = document.getElementById('email_client').value.trim();
            const tel = document.getElementById('tel_client').textContent;
            const empId = document.getElementById('id_employe').value;
            const dateVal = document.getElementById('date_reservation').value;
            const heureVal = document.getElementById('heure_reservation_time').value;

            // Vérifie les champs obligatoire avant d'envoyer la demande
            if (!nom || !email || !tel || !dateVal || !heureVal) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }*/

            // Génère un code aléatoire pour la réservation et le PDF
           /* const randomCode = 'RES-' + Math.floor(1000 + Math.random() * 9000);
            generatedReservationCode = '#' + randomCode;
            generatedPdfPath = `/tickets/ticket_${randomCode.toLowerCase()}.pdf`;

            // Met à jour le ticket visuel avec les données saisies
            document.getElementById('disp_id_res').textContent = generatedReservationCode;
            document.getElementById('disp_id_user').textContent = `USR-${Math.floor(100 + Math.random() * 900)} (${nom})`;
            document.getElementById('disp_barcode').textContent = `${randomCode}-2026`;

            // Date et heure actuelle de création de la réservation
            const now = new Date();
            const timestampStr = now.toISOString().replace('T', ' ').substring(0, 16);
            document.getElementById('disp_created').textContent = timestampStr;
            document.getElementById('pdfDownloadSection').classList.remove('hidden');
        }*/
        
        

        // ------------------------------------------------------------
        // 5) GÉNÉRATION DU PDF DU TICKET DE RÉSERVATION
        // ------------------------------------------------------------
       /* function generateAndDownloadPDF() {
            // Charge la bibliothèque jsPDF depuis le CDN déclaré dans le <head>
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Récupère les informations affichées côté interface
            const resCode = document.getElementById('disp_id_res').textContent;
            const clientName = document.getElementById('nom').value.trim();
            const empSelect = document.getElementById('id_employe');
            const empName = empSelect.options[empSelect.selectedIndex].getAttribute('data-name');
            const dateVal = document.getElementById('date_reservation').value;
            const heureVal = document.getElementById('heure_reservation_time').value;
            const createdAt = document.getElementById('disp_created').textContent;

}*/
        
 
    