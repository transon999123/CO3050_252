<?php
// src/Controllers/NewsController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/NewsModel.php';

class NewsController extends Controller {
    private $newsModel;

    public function __construct() {
        $this->newsModel = new NewsModel();
    }

    public function index() {
        $newsList = $this->newsModel->getLatestNews(10);
        $this->renderFrontend('news/index', [
            'page_title' => 'Tin Tức Thời Trang',
            'newsList' => $newsList
        ]);
    }

    public function detail() {
        $id = (int)($_GET['id'] ?? 0);
        $news = $this->newsModel->getNewsById($id);
        
        if(!$news) {
            die("Không tìm thấy bài viết.");
        }

        $this->newsModel->incrementViews($id);

        $this->renderFrontend('news/detail', [
            'page_title' => $news['title'],
            'news' => $news
        ]);
    }
}
