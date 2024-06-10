<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    asd
    <a href="./about.php">about</a>
    <button onclick="isMsg()">msg</button>
    <button onclick="files()">file</button>
    <button onclick="dirs()">dir</button>
    <script>
        async function isMsg() {
            let msg = await win_alert("你好", 1)
            console.log(msg)
        }
        async function files() {
            let file = await win_file_dialog()
            console.log(file)
        }
        async function dirs() {
            let dir = await win_open_dir()
            console.log(dir)
        }
    </script>
</body>

</html>