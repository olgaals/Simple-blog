<?php
class PostsController extends Zend_Controller_Action{
	
//public function __construct()
  //  {
        //...
        // this tells the framework to run the MenuController after this
       // $this->_helper->actionStack('posts', 'menu');
    //}
	
	public function indexAction()
    {

        $posts = new Posts();
		$users = new Users();

		$usersTable = $users->info(Zend_Db_Table::NAME);
		$postsTable = $posts->info(Zend_Db_Table::NAME);

		//Выбираем все посты и пользователей, которые их оставили
		$select = $posts->select()->setIntegrityCheck(false)->from(array('t1' => $usersTable))->join(array('t2' => $postsTable),'t1.id = t2.email_id');
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
		$this->view->path = $config->path->posts->get->images;
		$this->view->posts = $posts->fetchAll($select);
		
		
		//Проверяем авторизован ли пользователь
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			$this->view->authorathed = 1;
			
		} else {
			$this->view->authorathed = 0;
		}
		
		$this->view->title = "View posts";
   		$this->view->headTitle("Simple Blog | ".$this->view->title, 'PREPEND');
   		$this->_helper->actionStack('posts', 'menu');
   		$this->_helper->actionStack('right', 'menu');
    }

	public function postAction()
    {
        // ID из параметра

        $id = intval($this->_getParam('id', 0));
        if ($id > 0) {
        	            // Создаем экземпляр модели постов и выбираем посты по ID
            $post = new Posts();
            $this->view->post = $post->getById($id);
            // Устанавливаем заголовок для поста в тег title
            $this->view->postTitle = $this->view->post['title'];
            $this->view->headTitle($this->view->postTitle);
            // Получаем комменты к посту
            $comments = new Comments();
           // $this->view->comments = $comments->getByPostId($id);
	    
			$users = new Users();
			$usersTable = $users->info(Zend_Db_Table::NAME);
			$commentsTable = $comments->info(Zend_Db_Table::NAME);
			$postsTable = $post->info(Zend_Db_Table::NAME);
			//Выбираем пост и пользователя, который его оставил
			$select = $post->select()->setIntegrityCheck(false)->from(array('t1' => $usersTable))->join(array('t2' => $postsTable),'t1.id = t2.email_id')->where('t1.id = ' . $id);
		
			$this->view->posts = $post->fetchRow($select);

			$usersTable = $users->info(Zend_Db_Table::NAME);
			$commentsTable = $comments->info(Zend_Db_Table::NAME);
			$select = $comments->select()->setIntegrityCheck(false)->from(array('t1' => $usersTable))->join(array('t2' => $commentsTable),'t1.id = t2.email_id')
			->where('post_id = ' . $id);
			$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
			$this->view->path = $config->path->comments->get->images;
			$this->view->comments = $comments->fetchAll($select);
			
			$auth = Zend_Auth::getInstance();
			if($auth->hasIdentity()) {
				$this->view->authorathed = 1;
				
	            // Форма
	            $form = new CommentsForm();
	            // Устанавливаем value для скрытого элемента postId
	            $form->postId->setValue($id);
	            // Передаем форму во вьюшку
	            $this->view->form = $form;

	            // Если произведен запрос методом POST, т.е. форма отправлена
	           	 if ($this->getRequest()->isPost()) {
                // Получаем данные и проверяем на валидность
                		$formData = $this->getRequest()->getPost();
                		if ($form->isValid($formData)) {
		                    // Берем значения из формы
		                    $postId  = intval($form->getValue('postId'));
							$authInfo = Zend_Auth::getInstance()->getStorage()->read();
							$email_id = $authInfo->id;
							$form->email_id->setValue($email_id);

							$filter = new Zend_Filter_HtmlEntities(array('quotestyle' => ENT_QUOTES));
							//print $formData["blogComment"];exit;
							$comment = $filter->filter($this->addRelAnchorsAttribute($formData["blogComment"]));
		                   // print $comment = $form->getValue('blogComment');exit;
		                    // Вставляем в БД
		
		                    	/*$file = $form->image->getFileInfo();
		                    	$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
							 	//print_r($file);exit;
							 	if($file["image"]["name"]){
									$n_image = $this->fileRename($file["image"]["name"]);
									$form->image->addFilter('Rename', $config->path->comments->images.$n_image);
		
		                			if ($form->image->receive()) {
										//$image=$form->image->getValue();
										$image = $n_image;      
						   			}
			                   	    else{
								    	$image = "";	
							    	}
								}	*/

                   			 $comments->add($postId, $email_id, $comment);

                   				 // Редирект
                    		$this->_helper->redirector('post', 'posts', null, array('id' => $postId));
                		} else {
	                    // Если валидация не пройдена, заполняем форму введенными данными
	                    $form->populate($formData);
                	}
           		 }
			} else {
				$this->view->authorathed = 0;
				//$this->_redirect('auth/login');
			}
        }
        $this->view->title = "";
   		$this->view->headTitle("Simple Blog | ".$this->view->title, 'PREPEND');
   		$this->_helper->actionStack('post', 'menu');
   		$this->_helper->actionStack('right', 'menu');
    }

    

	public function createAction(){
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()) {
				$this->view->authorathed = 0;
				 $this->_redirect('auth/login');
		}else{
	   		$titles = new Posts();
			$form = new PostsForm();
			//$form->setAttrib('enctype', 'multipart/form-data');
			$this->view->form = $form;
			if ($this->getRequest()->isPost()) {
	                // Получаем данные и проверяем на валидность
	                $formData = $this->getRequest()->getPost();
	                if ($form->isValid($formData)) {
	                    // Берем значения из формы
                	
						$authInfo = Zend_Auth::getInstance()->getStorage()->read();
						$email_id = $authInfo->id;
			
						$form->email_id->setValue($email_id);
	                    $title     = $form->getValue('title');
	                    $filter = new Zend_Filter_HtmlEntities(array('quotestyle' => ENT_QUOTES));
	                    //$this->addRelAnchorsAttribute($formData["post"]);
	                	//$post = $filter->filter($formData["post"]);
	                	$post = $filter->filter($this->addRelAnchorsAttribute($formData["post"]));
	                	//print $post; exit;
	                   // $post = $form->getValue('post');
	                    
	                  
	                   /* $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
						$file = $form->image->getFileInfo(); 
						if($file["image"]["name"]){
							$n_image = $this->fileRename($file["image"]["name"]);
							$form->image->addFilter('Rename', $config->path->posts->images.$n_image);
							if ($form->image->receive()) {
								  	$image=$n_image;
						    }
						    else{
						    	$image = "";	
						    }
						}  */  
					    
	                    // Вставляем в БД
	                    $titles->add($email_id, $title, $post);
	
	                    // Редирект
	                    $this->_helper->redirector('index', 'posts', null);
	                } else {
	                    // Если валидация не пройдена, заполняем форму введенными данными
	                    $form->populate($formData);
	                }
	        }
	        $this->view->authorathed = 1;
	    }    
	    $this->view->title = "Create post";
   		$this->view->headTitle("Simple Blog | ".$this->view->title, 'PREPEND');
   		$this->_helper->actionStack('create', 'menu');
   		$this->_helper->actionStack('right', 'menu');
	}
	
	protected function fileRename($f_name){
		$ext = explode('.', $f_name);
		$n = count($ext)-1;
		$image = 'image_'.uniqid().".".$ext[$n];
    	return $image;
    }
    
    
	public function addRelAnchorsAttribute($str) {

		$str = htmlspecialchars_decode($str);
		$text = '<a href="http://www.test.com" title="test">http://www.test.com</a> something else hello world';
		$dom = new DOMDocument();
		$dom->loadHTML($str);

		
		$xpath = new DOMXPath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		
		for ($i = 0; $i < $hrefs->length; $i++) {
			$href = $hrefs->item($i);
			$href->setAttribute("rel", "nofollow");
		}
		$str = preg_replace("/<!DOCTYPE [^>]+>/", "", str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
		
		//$str=$dom->saveHTML();
		//print $str;
		return $str;
		//$regex = "/&lt;[\s]*a[\s]*href=[\s]*[\"\']?([\w.-]*)[\"\']?[^>]*&gt;(.*?)&lt;\/a&gt;/i";//(?P<link>\S+)
		
		//preg_replace($pattern, $replacement, $subject)
    	//preg_match_all($regex, $str, $match);
		//print_r($match);
		
		//$match[0][0] = str_replace("&lt;a", "&lt;a rel=\"nofollow\"", $match[0][0]);
		
		/*$regex = "/&lta.*?href\s*=\s*[\"'](.*?)['\"].*?&gt;(.*?)&lt;/a&gt;/i";
		preg_match_all($regex, $str, $match);
		print_r($match);
    	foreach ($match['link'] as $key=>$val) {
    		print_r($match['link']);
    			$pattern[] = '/'.preg_quote($match[0][$key],'/').'/';
    			$replace[] = "&lt;a rel=\"nofollow\"";
    			//print $key."<br>";
    	}*/
    	//print_r($pattern);
    	//print preg_replace($pattern, $replace, $str);
   }

}
?>