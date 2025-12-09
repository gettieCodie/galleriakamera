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
            position: relative;
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
        
        /* Contact Details Tooltip */
        .contact-tooltip {
            position: absolute;
            bottom: -120px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            border: 1px solid rgba(255, 255, 255, 0.1);
            pointer-events: none;
            min-width: 200px;
            text-align: left;
            white-space: normal;
        }
        
        .contact-tooltip::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #2c2c2c;
        }
        
        .call-btn:hover .contact-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-10px);
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        
        .contact-item:last-child {
            margin-bottom: 0;
        }
        
        .contact-item i {
            width: 16px;
            text-align: center;
            color: white;
            font-size: 14px;
        }
        
        .contact-item span {
            font-weight: 500;
            font-size: 13px;
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
    <button class="call-btn" id="callButton">
        Contact Us
        <div class="contact-tooltip">
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <span>0912 345 6789</span>
            </div>
            <div class="contact-item">
                <i class="fab fa-facebook"></i>
                <span>Galleria Kamera</span>
            </div>
        </div>
    </button>
    
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