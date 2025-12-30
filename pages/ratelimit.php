<!DOCTYPE html>
<html>

<head>
    <title>Rate Limit</title>
    <style>
        body {
            background-color: #010409;
            font-family: sans-serif;
            color: #AAA;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 80px 30px;
            text-align: center;
        }

        .title {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #f85149;
        }

        .description {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .code-block {
            background-color: transparent;
			border: 1px solid #0D1117;
            padding: 20px;
            border-radius: 5px;
            overflow-x: auto;
        }

        pre {
            margin: 0;
        }

        code {
            color: #AAA;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title">403 Forbidden</h1>
        <p class="description">Hız limiti aşıldığı için geçici olarak engellendiniz.</p>
        <p class="description">Daha sonra tekrar deneyiniz.</p>
        <br>
        <div class="code-block">
            <pre>
<code>HTTP/1.1 403 Forbidden
Content-Type: application/json
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 0
X-RateLimit-Reset: 1559347200
{"error": "Rate limit exceeded"}</code>
</pre>
        </div>
    </div>
</body>

</html>