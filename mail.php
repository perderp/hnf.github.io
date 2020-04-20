<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // access
        $secretKey = '6LcjbdgUAAAAAJwTPPN25XYO4GL2UfLlkRtGc-0n';
        $captcha = $_POST['g-recaptcha-response'];
        if(!$captcha){
          echo '<p class="alert alert-warning">コンピュータによる自動処理ではないことを確認するため、CAPTCHA認証フォームへチェックを入れてください。</p>';
          exit;
        }
        # FIX: Replace this email with recipient email
        $recipients = array(            
            "info2121@hnbo-h.com",
            // more emails
          );
        $mail_to = implode(',', $recipients);
        #FIX : Subject is fixed
        $subject = "（株）HNBO宛にメッセージが届きました。";
        # Sender Data
        $company = trim($_POST["company_name"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["person_inCharge"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $number = $_POST["tel_no"];
        $message = trim($_POST["message"]);
        if ( empty($company) OR empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($number) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo '<p class="alert alert-warning">入力内容を再度ご確認いただき、再送信してください。</p>';
            exit;
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
          echo '<p class="alert alert-warning">コンピュータによる自動処理ではないことを確認するため、CAPTCHA認証フォームへチェックを入れてください</p>';
        } else {
            # Mail Content
            $content = "会社名: $company\n";
            $content .= "お名前: $name\n";
            $content .= "Eメールアドレス: $email\n";
            $content .= "お電話番号: $number\n\n";
            $content .= "メッセージ:\n$message\n";
            # email headers.
            $headers = "From: $name <$email>";
            # Send the email.
            $success = mail($mail_to, $subject, $content, $headers);
            if ($success) {
                # Set a 200 (okay) response code.
                http_response_code(200);
                echo '<p class="alert alert-success">ありがとうございます！メッセージは無事送信されました！</p>';
            } else {
                # Set a 500 (internal server error) response code.
                http_response_code(500);
                echo '<p class="alert alert-warning">申し訳ありません。エラーが発生したためにメッセージを送信できませんでした。</p>';
            }
        }
    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo '<p class="alert alert-warning">ご入力内容に誤りがあります。再度ご確認のうえ再送信をお願いいたします。</p>';
    }
?>