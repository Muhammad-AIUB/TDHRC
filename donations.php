<?php include('topnav.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDHRC - Donate</title>
    <link rel="stylesheet" href="css/donate.css">
</head>
<body>
    <!-- Hero Start -->
    <div class="slider-area2" style="background-image: url('https://www.who.int/images/default-source/departments/ntd-library/schistosomiasis/mda-campaign-tanzania/43967524160-58148fb032-3k.tmb-1200v.jpg?Culture=en&sfvrsn=c39707b7_2');"> 
    </div>
    <div class="container">
        <!-- Section 1 -->
        <div class="content-section">
            <div class="content">
                <h2>Donate</h2>
                <p>
                    Your contributions, regardless of the amount, enable us to enhance the quality of life for millions vulnerable to tropical diseases through research, prevention, treatment, and control efforts, while also expanding healthcare accessibility.
                </p>
                <p>
                    • Ensure universal access to healthcare services
                </p>
                <p>
                    • Foster a robust research environment promoting evidence-based healthcare systems
                </p>
                <p>
                    • Advance research on tropical diseases for improved prevention and treatment strategies
                </p>
                <p>
                    • Foster collaborative approaches for generating and implementing scientific evidence in healthcare services
                </p>
                <p>
                    Each donation propels our efforts in tropical medicine and healthcare system research and development. This includes extending our reach to more individuals, supporting emerging researchers, facilitating collaborative policymaking, and influencing implementation outcomes across all levels of society for the betterment of quality of life.
                </p>
                <p>
                    Thank you for considering supporting our mission and making a positive impact on healthcare accessibility and outcomes.
                </p>
                <p>
                    <a href="contact.php" class="button">Join Us Now</a>
                </p>
            </div>
            <div class="content">
                <img src="https://www.plateaupeacebuilding.org/images/donate.gif" alt="Image">
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