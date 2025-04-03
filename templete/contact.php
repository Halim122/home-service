<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('../image/backg.jpg');
            background-color: #333;
            color: white;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #444;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .info-box {
            background: #555;
            padding: 15px;
            border-radius: 8px;
            flex: 1;
            text-align: center;
            min-width: 250px;
        }

        .info-box i {
            font-size: 30px;
            color: lightgreen;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
            background: #555;
            padding: 20px;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
        }

        button {
            background: lightgreen;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover {
            background: green;
        }

        
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Contact Us</h1>

        <div class="contact-info">
            <div class="info-box">
                <i class="fas fa-map-marker-alt"></i>
                <p>406 B city,South City, Kenya</p>
            </div>
            <div class="info-box">
                <i class="fas fa-phone"></i>
                <p>+254 456 7890</p>
            </div>
            <div class="info-box">
                <i class="fas fa-envelope"></i>
                <p>homeservices@business.com</p>
            </div>
        </div>

        <form id="contact-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <script>
        document.getElementById("contact-form").addEventListener("submit", function(event) {
            event.preventDefault();
            alert("Your message has been sent successfully!");
            this.reset();
        });
    </script>

</body>
</html>
