<?php
require_once("UserModel.class.php");
require_once("QuestionModel.class.php");

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->session = new Zend_Session_Namespace('Default');
    }

    public function indexAction()
    {
        
    }

    public function registAction()
    {
    	$email= $_POST["email"];

    	$usermodel = new UserModel();
    	$user_id = $usermodel->registUser($email);

    	$this->session->user_id = $user_id;

        $this->_helper->viewRenderer->setNoRender();

		$this->getResponse()
            ->setHeader('Content-Type', 'text/plain')
            ->setHeader('Content-Encoding', 'UTF-8')
            ->appendBody(json_encode(array("result" => "success")));
    }

    public function detailAction()
    {
    	$id = $this->getRequest()->getParam("id");

    	$questionmodel = new QuestionModel();
    	$question = $questionmodel->findQuestionById($id);

        // action body
        $this->view->src = $question->photo.".png";
        $this->view->question_id = $question->question_id;
        $this->view->content = $question->content;

        $json = json_decode($question->comments);
        if(empty($json)) return;

        $sentence = $json[0]->text;
        
        /**
		 * Yahoo! JAPAN Web APIのご利用には、アプリケーションIDの登録が必要です。
		 * あなたが登録したアプリケーションIDを $appid に設定してお使いください。
		 * アプリケーションIDの登録URLは、こちらです↓
		 * http://e.developer.yahoo.co.jp/webservices/register_application
		 */
		$appid = 'dj0zaiZpPWxTWnJpSnU3amN6NCZzPWNvbnN1bWVyc2VjcmV0Jng9ODI-'; // <-- ここにあなたのアプリケーションIDを設定してください。
		$url = "http://jlp.yahooapis.jp/MAService/V1/parse?appid=".$appid."&results=ma";
	    $url .= "&sentence=".urlencode($sentence);
	    $xml  = simplexml_load_file($url);
	    
	    $words = array();
	    foreach($xml->ma_result->word_list->word as $data)
    	{
    		if($data->pos == "名詞")
    		{
	    		$words[] = (string)$data->surface;
    		}
    	}

    	$word = urlencode($words[0]);
    	$appid_rakuten = "1020520224595893395";
    	$url = <<<REQ
https://app.rakuten.co.jp/services/api/Kobo/EbookSearch/20140811?applicationId={$appid_rakuten}&title={$word}&keyword={$word}&formatVersion=2&hits=3
REQ;
		$result = file_get_contents($url);
		// Will dump a beauty json :3
		$this->view->books = json_decode($result, true);

    }

    public function uploadAction()
    {
        try{
        	$content= "";//$_POST["content"];

            $comments= $_POST["comments"];

        	$img= $_POST["img"];

    		// ヘッダに「data:image/png;base64,」が付いているので、それは外す
    		$img= preg_replace("/data:[^,]+,/i","",$img);
    		 
    		// 残りのデータはbase64エンコードされているので、デコードする
    		$img= base64_decode($img);
    		  
    		// 文字列状態から画像リソース化
    		$image = imagecreatefromstring($img);
    		  
    		//画像として保存（ディレクトリは任意）
    		imagesavealpha($image, TRUE); // 透明色の有効

    		date_default_timezone_set('Asia/Tokyo');

    		$filename = date("YmdHis");
    		imagepng($image ,'./'.$filename.'.png');

        	$questionmodel = new QuestionModel();
        	$id = $questionmodel->registQuestion($this->session->user_id, $content, $filename, $comments);

            $usermodel = new UserModel();
            $user = $usermodel->findUserById($this->session->user_id);

            $message = <<< MESSAGE
いつも質問丸をご利用いただきありがとうございます。

新しい質問が投稿されました！

是非以下から確認して、回答してください！

http://quickstart/index/detail?id={$id}

よろしくお願い致します。

------------------
いつも、あなたと質問を。質問丸。
http://quickstart
0120-1234-5678

～マルチメディア質問サービス～
質問丸
MESSAGE;

            $this->_sendmail($message, $user->email);

            $this->_helper->viewRenderer->setNoRender();

    		$this->getResponse()
                ->setHeader('Content-Type', 'text/plain')
                ->setHeader('Content-Encoding', 'UTF-8')
                ->appendBody(json_encode(array("result" => "success", "id" => $id)));

        } catch(Exception $ex){
            $this->_helper->viewRenderer->setNoRender();
            $this->getResponse()
                ->setHeader('Content-Type', 'text/plain')
                ->setHeader('Content-Encoding', 'UTF-8')
                ->appendBody(var_export($ex, true));
        }
    }

    private function _sendmail($message, $to){
        $mail = new Zend_Mail('ISO-2022-JP');
        $mail->setBodyText($this->mbCnv($message))
        ->setFrom($this->mbCnv('info@shitsumon.com'), $this->mbCnv('マルチメディア質問サービス：質問丸'))
        ->addTo($to)
        ->setSubject($this->mbCnv('新しい質問が投稿されました！'))
        ->send();
    }

    private function mbCnv($string) {
        return mb_convert_encoding($string, 'ISO-2022-JP', 'UTF-8');
    }
}

