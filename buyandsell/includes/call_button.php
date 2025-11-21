<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Button for Nav Bar</title>
    <style>
        .call-btn {
            background: #2c2c2c;
            border: none;
            border-radius: 5px;
            width: 120px;
            height: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            color: white;
            font-size: 14px;
            font-weight: 450;
            letter-spacing: 0.5px;
            margin-left: 15px;
        }
        
        .call-btn:hover {
            background: #404040;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        
        .call-btn.playing {
            background: #2c2c2c;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { 
                box-shadow: 0 0 0 0 rgba(44, 44, 44, 0.7); 
            }
            70% { 
                box-shadow: 0 0 0 10px rgba(44, 44, 44, 0); 
            }
            100% { 
                box-shadow: 0 0 0 0 rgba(44, 44, 44, 0); 
            }
        }
    </style>
</head>
<body>
    <!-- This is the call button - just add this to your nav bar -->
    <button class="call-btn" id="callButton">Contact Us</button>
    
    <!-- Hidden audio element -->
    <audio id="audioPlayer" preload="auto">
        <source src="assets/images/m.mp3juice.win - One call away (lyrics) - Charlie Puth (320 KBps).mp3" type="audio/mpeg">
    </audio>

    <script>
        const callButton = document.getElementById('callButton');
        const audioPlayer = document.getElementById('audioPlayer');
        
        let isPlaying = false;
        
        // Set the start and end time for the audio clip (in seconds)
        const clipStart = 2;
        const clipEnd = 15;
        
        // Set the audio to start at the desired position
        audioPlayer.currentTime = clipStart;
        
        callButton.addEventListener('click', function() {
            if (!isPlaying) {
                // Start playing
                audioPlayer.play();
                isPlaying = true;
                callButton.classList.add('playing');
                callButton.textContent = 'Contact Us';
            } else {
                // Stop playing
                audioPlayer.pause();
                audioPlayer.currentTime = clipStart;
                isPlaying = false;
                callButton.classList.remove('playing');
                callButton.textContent = 'Contact Us';
            }
        });
        
        // Reset when audio ends naturally
            audioPlayer.addEventListener('ended', function() {
            audioPlayer.currentTime = clipStart;
            isPlaying = false;
            callButton.classList.remove('playing');
        });
    </script>
</body>
</html>