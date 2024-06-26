<?php

namespace app\controllers;

use app\models\Author;
use app\models\Books;
use app\models\Category;
use app\models\Comment;
use app\models\Favorites;
use app\models\History;
use app\models\Proposal;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

    //    Авторизация
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->is_admin)
            {
                return $this->redirect(['/admin']);
            } else {
                return $this->redirect(['site/index']);
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    //    Регистрация
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */

    //    Выход из ссесии
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Displays homepage.
     *
     * @return string
     */

    //    Вывод на главной странице отфильтрованных и обычных книг с пагинацией
    public function actionIndex()
    {
        $searchModel = new \app\models\SearchModel();
        $new = Books::find()->orderBy(['date' => SORT_DESC])->limit(5)->all();
        $query = Books::find()->orderBy('date asc');
        $count = clone $query;
        $pages = new Pagination(['totalCount'=>$count->count(), 'pageSize'=>5]);

        $books = $query->offset($pages->offset)->limit($pages->limit)->all();

        $populars = Books::find()
            ->where(['>', 'viewed', 0]) // Условие: количество просмотров больше нуля
            ->orderBy(['viewed' => SORT_DESC])
            ->limit(5)
            ->all();
        $categories = Category::find()->all();
        $author = Author::find()->all();
        return $this->render('index', ['categories'=>$categories, 'populars'=>$populars, 'books'=>$books, 'new'=>$new, 'author'=>$author, 'pages'=>$pages, 'searchModel'=>$searchModel]);
    }

    //    Нахождение рандомной книги
    public function actionRandomBook()
    {
        // Получаем случайный ID книги из базы данных
        $randomBookId = Yii::$app->db->createCommand('SELECT id FROM books ORDER BY RAND() LIMIT 1')->queryScalar();

        // Проверяем, что удалось получить случайный ID
        if ($randomBookId !== false) {
            // Перенаправляем пользователя на страницу случайной книги
            return $this->redirect(Url::to(['site/books', 'id' => $randomBookId]));
        } else {
            // Если случайную книгу не удалось получить, выполните необходимые действия (например, показ сообщения об ошибке)
            Yii::$app->session->setFlash('error', 'Не удалось получить случайную книгу.');
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
    }

    //    Подробная информация о кнги, создание комментария, вывод текста из кнги, добавление в истрорию
    public function actionBooks($id)
    {
        $books = Books::findOne($id);
        $user_id = Yii::$app->user->id;

        // Увеличить счетчик просмотров книги в Redis
//    $redis = Yii::$app->redis;
//    $redis->incr("book:$id:views");
//    $views = $redis->get("book:$id:views");

        $addToFavoriteUrl = Url::to(['site/add-to-favorite', 'id' => $books->id]);
        $removeFromFavoriteUrl = Url::to(['site/remove-from-favorite', 'id' => $books->id]);

        $authorId = Yii::$app->request->get('author_id');
        $author = Author::findOne($authorId);

        // История
        // Проверим, существует ли уже запись в истории для данной книги и пользователя
        $history = History::find()
            ->where(['user_id' => $user_id, 'books_id' => $books->id])
            ->one();

        // Если записи нет, создадим новую
        if (!$history) {
            $history = new History();
            $history->user_id = $user_id;
            $history->books_id = $books->id;
        }

        // Обновим время создания записи в истории
        $history->created_at = date('Y-m-d H:i:s');
        $history->save();

        $comments = Comment::find()->where(['books_id' => $id])->all();
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->books_id = $books->id; // Присваиваем ID книги комментарию
            $model->user_id = $user_id;    // Присваиваем ID пользователя комментарию

            if ($model->save()) {
                return $this->refresh();
            }
        }

        $favorite = Favorites::findOne(['user_id' => $user_id, 'books_id' => $id]);

        // Получаем текст книги и разбиваем на страницы
        $filePath = 'file/' . $books->file;
        $pages = $this->getBookPages($filePath);

        // Получаем номер страницы из запроса
        $pageNumber = Yii::$app->request->get('page', 1);
        $pageNumber = max(1, min($pageNumber, count($pages))); // Проверяем, что номер страницы в пределах допустимого

        $currentPageContent = $pages[$pageNumber - 1];

        $context = [
            'author' => $author,
            'books' => $books,
            'model' => $model,
            'comments' => $comments,
            'addToFavoriteUrl' => $addToFavoriteUrl,
            'removeFromFavoriteUrl' => $removeFromFavoriteUrl,
            'favorite' => $favorite,
            'currentPageContent' => $currentPageContent,
            'totalPages' => count($pages),
            'currentPage' => $pageNumber,
        ];

        return $this->render('books', $context);
    }

    private function getBookPages($filePath, $pageSize = 2000)
    {
        $content = file_get_contents($filePath);
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');

        // Разделение строки на части с учетом многобайтовых символов
        $pages = mb_str_split($content, $pageSize);
        return $pages;
    }


    //    Добавить в избранное
    public function actionAddToFavorite($id)
    {
        $user_id = Yii::$app->user->id;

        // Проверим, не существует ли уже записи для данного пользователя и книги
        $favorite = Favorites::findOne(['user_id' => $user_id, 'books_id' => $id]);

        // Если записи нет, создадим новую
        if (!$favorite) {
            $favorite = new Favorites();
            $favorite->user_id = $user_id;
            $favorite->books_id = $id;
            $favorite->save();
        }

        // Перенаправим пользователя на предыдущую страницу
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    //    Удалить из избранного
    public function actionRemoveFromFavorite($id)
    {
        $user_id = Yii::$app->user->id;

        // Находим запись в избранном для данного пользователя и книги
        $favorite = Favorites::findOne(['user_id' => $user_id, 'books_id' => $id]);

        // Если запись существует, удалим ее
        if ($favorite) {
            $favorite->delete();
        }

        // Перенаправим пользователя на предыдущую страницу
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    //    Вывод истории и избранного
    public function actionMy()
    {
        // Получите обновленную историю просмотра пользователя, отсортированную по времени создания в обратном порядке

        $userHistory = History::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        // Получите все записи избранного для данного пользователя
        $favoriteBooks = Favorites::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with('books')
            ->all();

        return $this->render('my', ['userHistory' => $userHistory, 'favoriteBooks' => $favoriteBooks,]);
    }

    //    Книги по авторам
    public function actionAuthor()
    {
        if (isset($_GET['id']) && $_GET['id']!='')
        {
            $authorId = Yii::$app->request->get('author_id');
            $author = Author::findOne($authorId);

            $books = Books::find()->where(['author_id'=>$_GET['id']])->asArray()->all();

            $context = ['author' => $author, 'books' => $books];

            return $this->render('author', $context);
        }
        else
            return $this->redirect(['author']);
    }

    //    Книги по категориям
    public function actionMycategory()
    {
        if (isset($_GET['id']) && $_GET['id']!='')
        {
            // Получаем данные о категории
            $category = Category::find()->where(['id'=>$_GET['id']])->one();

            if ($category !== null) {
                // Получаем все книги в выбранной категории
                $books = Books::find()->where(['category_id'=>$_GET['id']])->with('author')->all();

                // Формируем контекст для передачи в представление
                $context = ['category' => $category, 'books' => $books];

                return $this->render('mycategory', $context);
            } else {
                // Если категория не найдена, можно перенаправить пользователя на страницу с сообщением об ошибке или другое действие
                return $this->redirect(['error']);
            }
        }
        else {
            // В случае, если ID категории не был передан, можно выполнить другое действие, например, перенаправить на другую страницу
            return $this->redirect(['category']);
        }
    }

    //    Вывод категорий
    public function actionCategory()
    {
        $categories = Category::find()->all();
        $context = ['categories'=>$categories];
        return $this->render('category', $context);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    // Отправка заявок
    public function actionProposal()
    {
        $model = new Proposal();
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->body = Html::encode($model->body);  // Кодируем содержимое поля body

            if ($model->image && $model->image->size < 22016) {
                if ($model->upload()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Отправлено');
                    } else {
                        Yii::$app->session->setFlash('danger', 'Ошибка при сохранении данных');
                    }
                } else {
                    Yii::$app->session->setFlash('danger', 'Ошибка при загрузке файла');
                }
            } elseif (!$model->image) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Отправлено');
                } else {
                    Yii::$app->session->setFlash('danger', 'Ошибка при сохранении данных');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Файл слишком большой');
            }
            return $this->refresh();
        }

        return $this->render('proposal', [
            'model' => $model,
        ]);
    }

    //    Вывод личного кабинета
    public function actionKabinet()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);

        $proposal = Proposal::find()->where(['user_id' => $userId])->all();

        return $this->render('kabinet', ['proposal' => $proposal, 'user'=>$user]);
    }

    // Поиск книги
    public function actionSearch()
    {
        $searchModel = new \app\models\SearchModel(); // Создаем экземпляр модели поиска

        // Проверяем, был ли отправлен запрос поиска
        if ($searchModel->load(Yii::$app->request->get())) {
            // Проверяем, что запрос не пустой
            if (empty(trim($searchModel->query))) {
                // Если запрос пустой, перенаправляем пользователя на главную страницу
                return $this->redirect(Yii::$app->homeUrl);
            }

            // Разбиваем запрос пользователя на отдельные слова
            $keywords = explode(' ', strtolower($searchModel->query));

            // Создаем массив для хранения наиболее подходящих книг
            $matchingBooks = [];

            // Перебираем каждое слово из запроса пользователя
            foreach ($keywords as $keyword) {
                // Ищем книги, содержащие текущее слово в названии
                $books = Books::find()->where(['like', 'LOWER(name)', $keyword])->all();
                // Если найдены книги, добавляем их в массив $matchingBooks
                if (!empty($books)) {
                    foreach ($books as $book) {
                        $matchingBooks[$book->id] = $book;
                    }
                }
            }

            // Если найдены какие-либо книги, выбираем наиболее подходящую
            if (!empty($matchingBooks)) {
                // Сортируем книги по количеству совпадающих слов
                usort($matchingBooks, function ($a, $b) use ($keywords) {
                    $countA = count(array_intersect($keywords, explode(' ', strtolower($a->name))));
                    $countB = count(array_intersect($keywords, explode(' ', strtolower($b->name))));
                    return $countB - $countA;
                });

                // Перенаправляем пользователя на страницу наиболее подходящей книги
                return $this->redirect(['books', 'id' => reset($matchingBooks)->id]);
            }
        }

        // Если книга не найдена, перенаправляем пользователя на главную страницу
        return $this->redirect(Yii::$app->homeUrl);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
