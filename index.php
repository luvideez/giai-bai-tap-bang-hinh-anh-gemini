<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            margin: 0;
            border-radius: 8px 8px 0 0;
        }

        #chatbox {
            width: 80%;
            height: 450px;
            border: 1px solid #ccc;
            margin: 20px auto;
            overflow-y: auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #chatbox p {
            margin: 15px 0;
            padding: 12px 18px;
            border-radius: 20px;
            font-size: 15px;
            line-height: 1.4;
            word-wrap: break-word;
            max-width: 70%;
        }

        #chatbox p.user {
            background-color: #DCF8C6;
            text-align: right;
            margin-left: auto;
            margin-right: 10px;
            border-bottom-right-radius: 2px;
        }

        #chatbox p.gemini {
            background-color: #E8EAED;
            text-align: left;
            margin-right: auto;
            margin-left: 10px;
            border-bottom-left-radius: 2px;
        }

        #chatbox p.system {
            background-color: #f0f0f0;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        /* Loại bỏ phần before của user và gemini */

        #chatbox p:hover {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
        }

        #messageForm {
            width: 80%;
            margin: 20px auto;
            display: flex;
            gap: 10px;
        }

        #message {
            flex-grow: 1;
            padding: 15px 20px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
            outline: none;
        }

        button[type="submit"] {
            padding: 15px 25px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        #imageInput {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h1>AI CHAT</h1>

    <div id="chatbox">
    </div>

    <form id="messageForm">
        <input type="text" name="message" id="message" placeholder="Nhập tin nhắn của bạn...">
        <button type="submit">Gửi</button>
    </form>
    <input type="file" id="imageInput" accept="image/*">

    <script>
        const form = document.getElementById('messageForm');
        const chatbox = document.getElementById('chatbox');
        const messageInput = document.getElementById('message');
        const imageInput = document.getElementById('imageInput');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const message = messageInput.value;
            messageInput.value = '';

            appendMessage('user', message);

            sendMessageToGemini(message);
        });

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                uploadImageAndProcess(file);
            }
        });

        function uploadImageAndProcess(file) {
            const formData = new FormData();
            formData.append('image', file);

            appendMessage('user', 'Đang tải ảnh lên...');

            fetch('ocr.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    appendMessage('user', 'Đã quét ảnh. Nội dung: ' + data.text);
                    sendMessageToGemini("Nội dung từ ảnh: " + data.text);
                } else {
                    appendMessage('system', 'Lỗi: ' + data.error);
                }
            })
            .catch(error => {
                appendMessage('system', 'Lỗi: Không thể kết nối đến server OCR.');
            });
        }

        function sendMessageToGemini(message) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'chat.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    appendMessage('gemini', xhr.responseText);
                } else {
                    appendMessage('system', 'Lỗi: Không thể kết nối đến server.');
                }
            };
            xhr.send('message=' + encodeURIComponent(message));
        }

        function appendMessage(type, message) {
          const messageElement = document.createElement('p');
          messageElement.classList.add(type);
          messageElement.innerHTML = message;
          chatbox.appendChild(messageElement);
          chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>
</body>
</html>
