<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Recorder</title>
</head>
<body>
    <h1>Audio Recorder</h1>
    <button id="recordBtn">Record Audio</button>
    <button id="stopBtn" disabled>Stop Recording</button>
    <audio id="audioPlayer" controls></audio>
    <div id="audioList"></div>
<style >
 body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        #audioPlayer {
            width: 100%;
            margin-top: 20px;
        }

        #audioList {
            margin-top: 20px;
        }

        audio {
            width: 100%;
        }

        button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 4px;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
   <script>
    let mediaRecorder;
    let chunks = [];

    const recordBtn = document.getElementById("recordBtn");
    const stopBtn = document.getElementById("stopBtn");
    const audioPlayer = document.getElementById("audioPlayer");
    const audioList = document.getElementById("audioList");

    const startRecording = () => {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then((stream) => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = (e) => chunks.push(e.data);
                mediaRecorder.onstop = saveRecording;
                mediaRecorder.start();
                recordBtn.disabled = true;
                stopBtn.disabled = false;
            })
            .catch((err) => {
                console.error("Error accessing the microphone:", err);
            });
    };

    const stopRecording = () => {
        mediaRecorder.stop();
        recordBtn.disabled = false;
        stopBtn.disabled = true;
    };

    const saveRecording = () => {
        const blob = new Blob(chunks, { type: 'audio/webm' });
        chunks = [];

        const formData = new FormData();
        formData.append("audio", blob);

        fetch("save_audio.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            // Handle the response if needed
        })
        .catch((error) => {
            console.error("Error saving audio:", error);
        });
    };

    recordBtn.addEventListener("click", startRecording);
    stopBtn.addEventListener("click", stopRecording);
</script>
<script>
    const fetchAudioRecords = () => {
        fetch("get_audio.php")
            .then((response) => response.text())
            .then((data) => {
                const audioList = document.getElementById("audioList");
                audioList.innerHTML = data;
            })
            .catch((error) => {
                console.error("Error fetching audio records:", error);
            });
    };

    fetchAudioRecords();
</script>

</body>
</html>
