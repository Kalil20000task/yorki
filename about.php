<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About the Developer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/ice.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9); /* White background with transparency */
            backdrop-filter: blur(8px); /* Blur effect */
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }

        .card img {
            border-radius: 50%; /* Circular image */
            width: 100px;
            height: 100px;
            object-fit: cover; /* Maintain aspect ratio */
        }

        .card h2 {
            margin: 10px 0;
            font-size: 24px;
            color: #5a3e36; /* Dark brown color */
        }

        .card p {
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.5;
        }

        .card a {
            text-decoration: none;
            color: #007bff; /* Link color */
            font-weight: bold;
            transition: color 0.3s;
        }

        .card a:hover {
            color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>

    <div class="card">
        <img src="images/developer.jpg" alt="Developer Photo"> <!-- Change to your developer image path -->
        <h2>About the Developer</h2>
        <p>Hello! I'm Kaleab Teame Gebremaryam, a passionate web developer with a love for creating beautiful and functional websites.</p>
        <p>I specialize in PHP, JavaScript, and Python, with a keen interest in machine learning and AI integration.</p>
        <p>Feel free to reach out for collaborations or inquiries!</p>
        <p>
            <a href="mailto:kale200017@gmail.com">Email Me</a>
        </p>
    </div>

</body>
</html>
