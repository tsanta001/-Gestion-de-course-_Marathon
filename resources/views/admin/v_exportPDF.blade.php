<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de Vainqueur</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f3f3f3;
        }

        .certificate {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            border: 10px solid #FF0000;
            background-color: #fff;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            color: #FF0000;
            margin: 0;
        }

        .header h2 {
            font-size: 1.5em;
            color: #333;
            margin: 0;
        }

        .content {
            margin-bottom: 30px;
        }

        .content p {
            font-size: 1.2em;
            color: #333;
            margin: 10px 0;
        }

        .content h2 {
            font-size: 2em;
            color: #FF0000;
            margin: 10px 0;
        }

        .content h3 {
            font-size: 1.5em;
            color: #333;
            margin: 10px 0;
        }

        .footer {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
        }

        .signature {
            text-align: center;
        }

        .signature p {
            margin: 5px 0;
        }

        .signature p:first-child {
            border-top: 1px solid #333;
            padding-top: 5px;
            width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1>Certificat de Vainqueur</h1>

            <h2>Marathon</h2>
            
        </div>
        <div class="content">
            <p>Ceci est pour certifier que</p>
            <h2>Equipe {{$classement_equipes[0]->nom}}</h2>
            <p>a remporté la première place lors de la course de marathon </p>
        </div>
        <div class="footer">
            <div class="signature">
                <p>__________________________</p>
                <p>Organisateur</p>
            </div>
            <div class="signature">
                <p>__________________________</p>
                <p>Juge Principal</p>
            </div>
        </div>
    </div>
</body>
</html>
