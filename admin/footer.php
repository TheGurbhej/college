</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        document.addEventListener("DOMContentLoaded", function() {
                // 1. Bar Chart: Attendance Trend
                const ctxAttendance = document.getElementById('attendanceChart').getContext('2d');
                new Chart(ctxAttendance, {
                        type: 'bar',
                        data: {
                                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                                datasets: [{
                                        label: 'Attendance (%)',
                                        data: [92, 94, 91, 95, 89, 85],
                                        backgroundColor: 'rgba(13, 110, 253, 0.7)', // Bootstrap Primary color
                                        borderColor: 'rgba(13, 110, 253, 1)',
                                        borderWidth: 1,
                                        borderRadius: 5
                                }]
                        },
                        options: {
                                responsive: true,
                                scales: {
                                        y: {
                                                beginAtZero: true,
                                                max: 100
                                        }
                                }
                        }
                });

                // 2. Doughnut Chart: Students by Department
                const ctxDept = document.getElementById('departmentChart').getContext('2d');
                new Chart(ctxDept, {
                        type: 'doughnut',
                        data: {
                                labels: ['BCA', 'B.Tech', 'BBA', 'B.Sc'],
                                datasets: [{
                                        data: [300, 500, 200, 150], // Yeh values aap PHP variables se bhi la sakte ho
                                        backgroundColor: [
                                                '#0d6efd', // Primary
                                                '#198754', // Success
                                                '#ffc107', // Warning
                                                '#dc3545' // Danger
                                        ],
                                        hoverOffset: 4
                                }]
                        },
                        options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                        legend: {
                                                position: 'bottom'
                                        }
                                }
                        }
                });
        });
</script>
<script>
        let cropper = null;
        let stream = null;

        const imageInput = document.getElementById("imageInput");
        const previewImage = document.getElementById("previewImage");
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const cropBtn = document.getElementById("cropBtn");


        // Upload Image
        imageInput.addEventListener("change", function(e) {

                const file = e.target.files[0];

                if (!file) return;

                const reader = new FileReader();

                reader.onload = function(event) {

                        previewImage.src = event.target.result;

                        previewImage.onload = function() {

                                if (cropper) {
                                        cropper.destroy();
                                }

                                cropper = new Cropper(previewImage, {
                                        aspectRatio: 1,
                                        viewMode: 1,
                                        autoCropArea: 1,
                                        responsive: true,
                                        dragMode: "move"
                                });

                        };

                };

                reader.readAsDataURL(file);

        });


        // Open Camera
        document.getElementById("startCamera").addEventListener("click", async function() {

                try {

                        stream = await navigator.mediaDevices.getUserMedia({
                                video: true
                        });

                        video.srcObject = stream;

                        document.getElementById("cameraContainer").classList.remove("d-none");
                        document.getElementById("captureBtn").classList.remove("d-none");

                } catch (e) {

                        alert("Camera permission denied.");

                }

        });


        // Capture Image
        document.getElementById("captureBtn").addEventListener("click", function() {

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                const ctx = canvas.getContext("2d");

                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                const image = canvas.toDataURL("image/png");

                previewImage.src = image;

                previewImage.onload = function() {

                        if (cropper) {
                                cropper.destroy();
                        }

                        cropper = new Cropper(previewImage, {
                                aspectRatio: 1,
                                viewMode: 1,
                                autoCropArea: 1
                        });

                };

                if (stream) {

                        stream.getTracks().forEach(track => track.stop());

                }

                document.getElementById("cameraContainer").classList.add("d-none");

        });


        // Crop & Submit
        cropBtn.addEventListener("click", function() {

                if (!cropper) {

                        alert("Please upload or capture image first.");
                        return;

                }

                const croppedCanvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 300
                });

                const croppedImage = croppedCanvas.toDataURL("image/png");

                // Hidden input
                document.getElementById("cropped_image").value = croppedImage;

                // Profile preview
                document.querySelector(".profile-img").src = croppedImage;

                // Form Submit
                cropBtn.closest("form").submit();

        });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="js/script.js"></script>

<script>
        new DataTable('#onlineform', {
                paging: false,
                searching: true,
                language: {
                        search: "Search student",
                        searchPlaceholder: "Type to search..."
                },
                ordering: false,
                info: false,
        });
</script>


</body>

</html>