<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Doctor</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background: #fff;
        }
        
        h2 {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .search-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        
        .search-input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: border-color 0.3s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #2196F3;
        }
        
        .doctor-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
            display: none;
        }
        
        .doctor-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        
        .doctor-item:hover {
            background-color: #f0f0f0;
        }
        
        .doctor-item:last-child {
            border-bottom: none;
        }
        
        .doctor-item.selected {
            background-color: #e3f2fd;
        }
        
        .doctor-details {
            margin-top: 20px;
            padding: 20px;
            background: #fff3e0;
            border-radius: 5px;
            border-left: 4px solid #ff9800;
            display: none;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }
        
        .detail-value {
            color: #666;
        }
        
        .delete-section {
            margin-top: 30px;
            padding: 20px;
            background: #ffebee;
            border-radius: 5px;
            border-left: 4px solid #f44336;
            display: none;
        }
        
        .warning-text {
            color: #d32f2f;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        
        .btn-cancel {
            background-color: #9e9e9e;
            color: white;
        }
        
        .btn-cancel:hover {
            background-color: #757575;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .loading {
            text-align: center;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Delete Doctor</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="message success">Doctor deleted successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="message error">Failed to delete doctor. Please try again.</div>
        <?php endif; ?>

        <div class="search-section">
            <label for="doctor_search"><strong>Search Doctor:</strong></label>
            <input type="text" 
                   id="doctor_search" 
                   class="search-input" 
                   placeholder="Type doctor name to search..."
                   autocomplete="off">
            
            <div id="doctor_list" class="doctor-list"></div>
            <div id="loading" class="loading" style="display: none;">Searching...</div>
        </div>

        <div id="doctor_details" class="doctor-details">
            <h3>Doctor Information</h3>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value" id="detail_name"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">General Specialty:</span>
                <span class="detail-value" id="detail_genspec"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Special Specialty:</span>
                <span class="detail-value" id="detail_spespec"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Hospital:</span>
                <span class="detail-value" id="detail_hospital"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Governorate:</span>
                <span class="detail-value" id="detail_gove"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">District:</span>
                <span class="detail-value" id="detail_district"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Shift Period:</span>
                <span class="detail-value" id="detail_shift"></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span class="detail-value" id="detail_phone"></span>
            </div>
        </div>

        <div id="delete_section" class="delete-section">
            <div class="warning-text">⚠️ Warning: This action cannot be undone!</div>
            <p>Are you sure you want to delete this doctor's information?</p>
            
            <form id="delete_form" method="post" action="/doctors/delete">
                <input type="hidden" id="doctor_id" name="doctor_id" value="">
                <div class="button-group">
                    <button type="submit" class="btn btn-delete">Delete Doctor</button>
                    <button type="button" class="btn btn-cancel" onclick="cancelDelete()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let searchTimeout;
        let selectedDoctor = null;

        const searchInput = document.getElementById('doctor_search');
        const doctorList = document.getElementById('doctor_list');
        const loadingDiv = document.getElementById('loading');
        const doctorDetails = document.getElementById('doctor_details');
        const deleteSection = document.getElementById('delete_section');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                doctorList.style.display = 'none';
                hideDetails();
                return;
            }

            // Show loading
            loadingDiv.style.display = 'block';
            doctorList.style.display = 'none';

            // Debounce search
            searchTimeout = setTimeout(() => {
                searchDoctors(query);
            }, 300);
        });

        function searchDoctors(query) {
            fetch('/doctors/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'query=' + encodeURIComponent(query)
            })
            .then(response => response.json())
            .then(data => {
                loadingDiv.style.display = 'none';
                displayDoctors(data);
            })
            .catch(error => {
                loadingDiv.style.display = 'none';
                console.error('Search error:', error);
            });
        }

        function displayDoctors(doctors) {
            doctorList.innerHTML = '';
            
            if (doctors.length === 0) {
                doctorList.innerHTML = '<div class="doctor-item">No doctors found</div>';
            } else {
                doctors.forEach(doctor => {
                    const item = document.createElement('div');
                    item.className = 'doctor-item';
                    item.innerHTML = `
                        <strong>${doctor.doctor_name}</strong><br>
                        <small>${doctor.GenSpec} - ${doctor.Hospital}</small>
                    `;
                    item.onclick = () => selectDoctor(doctor, item);
                    doctorList.appendChild(item);
                });
            }
            
            doctorList.style.display = 'block';
        }

        function selectDoctor(doctor, element) {
            // Remove previous selection
            document.querySelectorAll('.doctor-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Add selection to clicked item
            element.classList.add('selected');
            
            selectedDoctor = doctor;
            
            // Hide doctor list
            doctorList.style.display = 'none';
            
            // Update search input
            searchInput.value = doctor.doctor_name;
            
            // Show doctor details
            showDoctorDetails(doctor);
        }

        function showDoctorDetails(doctor) {
            document.getElementById('detail_name').textContent = doctor.doctor_name;
            document.getElementById('detail_genspec').textContent = doctor.GenSpec;
            document.getElementById('detail_spespec').textContent = doctor.SpeSpec || 'N/A';
            document.getElementById('detail_hospital').textContent = doctor.Hospital;
            document.getElementById('detail_gove').textContent = doctor.Gove;
            document.getElementById('detail_district').textContent = doctor.District;
            document.getElementById('detail_shift').textContent = doctor.Shift_Period;
            document.getElementById('detail_phone').textContent = doctor.Phone;
            
            document.getElementById('doctor_id').value = doctor.ID;
            
            doctorDetails.style.display = 'block';
            deleteSection.style.display = 'block';
        }

        function hideDetails() {
            doctorDetails.style.display = 'none';
            deleteSection.style.display = 'none';
            selectedDoctor = null;
        }

        function cancelDelete() {
            hideDetails();
            searchInput.value = '';
        }

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.search-section')) {
                doctorList.style.display = 'none';
            }
        });
    </script>
</body>
</html>