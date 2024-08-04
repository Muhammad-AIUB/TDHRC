<?php include('topnav.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDHRC - About us</title>
    <link rel="stylesheet" href="css/aboutus.css">
</head>
<body>
    <div class="container">
        <!-- Section 1 -->
        <div class="content-section">
            <div class="content">
                <h2>Our Mission</h2>
                <p>
                    Prioritize tropical disease in health research for prevention and management of these diseases <br />
                    Develop a strong research culture in Bangladesh by creating a global collaborative platform for young enthusiastic researchers <br />
                    Create an equitable and accessible health system for the marginalized population of the society who are the vulnerable group for tropical diseases
                </p>
                <h2>Our Vision</h2>
                <p>
                    Improve health through evidence-based prevention and accessible healthcare system.
                </p>
            </div>
            <div class="content">
                <img src="https://blogs.biomedcentral.com/bugbitten/wp-content/uploads/sites/11/2020/01/Venn_NTDs_SDGs_HR_Research-1024x576.jpg" alt="Image">
            </div>
        </div>
        
        <!-- Section 2 -->
        <div class="content-section">
            <div class="content">
                <img src="https://img.freepik.com/premium-vector/medical-support-illustration_32854-259.jpg" alt="Image">
            </div>
            <div class="content">
                <h2>Our Goals</h2>
                <p>
                    Prioritizing research in tropical diseases<br>
                    Supporting young researchers for career development in tropical medicine/global health<br>
                    Fostering global scientific collaboration<br>
                    Advocacy for establishing an equitable health system for marginalized population<br>
                    Promoting evidence-based policy regarding tropical medicine and health
                </p>
                <h2>Priority Areas</h2>
                <p>
                    Emerging tropical diseases<br>
                    Dengue, Chikungunya, and other arboviral diseases<br>
                    Malaria and tuberculosis, with a focus on resistance<br>
                    Antimicrobial resistance<br>
                    Planetary health and One Health approach for improvement of animal health and the environment<br>
                    Health system research for improving equity and access for marginalized people
                </p>
                <a href="#" class="button">Learn More</a>
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