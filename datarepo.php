<?php include('topnav.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDHRC - Data Repository</title>
    <link rel="stylesheet" href="css/datarepo.css">
</head>
<body>
    <!-- Banner -->
    <div class="banner" style="position: relative; text-align: center; margin-bottom: 20px;">
        <img src="assets/cdc.jpg" alt="Banner Image" style="max-width: 100%; height: auto; border-radius: 10px;">
        <div class="banner-text" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 24px; font-weight: bold; background-color: rgba(0, 0, 0, 0.7); padding: 10px;">
            Welcome to Our Data Repository
        </div>
    </div>
    
    <div class="container">
        <!-- Option Images -->
        <h2 style="text-align: center;">Our areas of work</h2>
        <div class="options-wrapper">
            <div class="option">
                <a href="tropicaldiease.php">
                    <img src="assets/td.png" alt="Tropical Disease">
                    <div class="option-title">Tropical Disease</div>
                </a>
            </div>
            <div class="option">
                <a href="healthsystem.php">
                    <img src="assets/hs.jpg" alt="Health System">
                    <div class="option-title">Health System</div>
                </a>
            </div>
            <div class="option">
                <a href="dieasedata.php">
                    <img src="assets/dsd.png" alt="Disease Specific Data">
                    <div class="option-title">Disease Specific Data</div>
                </a>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="content-section">
            <div class="content">
                <center>
                <h2>Data Repository</h2>
                </center>
                <p>The Tropical Disease and Health Research Center (TDHRC) is a non-profit, independent, collaborative organization that works with multiple partners, agencies, and governments. It conducts multiple research projects with or without funding. Research data is valuable, and it should be used for the betterment of science and humanity. Therefore, we believe that it should be open, and hence, we want to share our dataset if there are no ethical and legal barriers.</p>
                <p>We have multiple project datasets that can be shared following the meeting of specific requirements.</p>
                <p>If you want to work with clinical, epidemiological, or disease-specific data and want to share your research or access research data, then you are welcome. Please see the following projects and if you want to access the dataset of any particular project, please email us: <a href="mailto:data@tdhrc.org">data@tdhrc.org</a> or <a href="mailto:dr.jahid61@gmail.com">dr.jahid61@gmail.com</a>.</p>
                <p>Please remember that as all of the datasets are already used and published, before accessing any data or request, please review the published paper and/or questionnaire first. Then make a short plan (350 words) on what you want to do and how you will analyze the dataset.</p>
                <p>As all data access is free of charge but with some conditions, before requesting data access please write a cover letter and share your short plan (350 words) in two separate documents along with your research profile (short CV) [Total 3 documents].</p>
                <p>As we receive a high volume of requests, we cannot reply to all emails. Only convincing emails will be replied to after a certain time.</p>
            </div>
            <div class="content">
                <img src="assets/dt.png" alt="Image">
            </div>
        </div>
    </div>

    <!-- Return to Top Button -->
    <a href="#" class="return-to-top"></a>

    <!-- Script for Return to Top Button -->
    <script>
        // Smooth scroll to top
        document.querySelector('.return-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Show or hide the button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                document.querySelector('.return-to-top').style.display = 'block';
            } else {
                document.querySelector('.return-to-top').style.display = 'none';
            }
        });
    </script>
</body>
</html>
<?php include('footer.php'); ?>