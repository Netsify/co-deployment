<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Сервис для работы с базой знаний
 *
 * Class KnowledgeBaseService
 * @package App\Services
 */
class KnowledgeBaseService
{
    private $_article;
    private $_user;

    /**
     * KnowledgeBaseService constructor.
     * @param Article $article
     * @param User $user
     */
    public function __construct(Article $article, User $user)
    {
        $this->_article = $article;
        $this->_user = $user;
    }

    /**
     * Создаём статью
     *
     * @param array|null $tags
     * @return bool
     */
    public function createArticle(array $tags = null): bool
    {
        $article = $this->_user->articles()->save($this->_article);

        if (!$article) {
            Log::error('Не удалось создать статью', [
                'article' => $this->_article->toArray(),
                'user'    => $this->_user->toArray()
            ]);

            return false;
        }

        $this->_article = $article;

        if (!empty($tags)) {
            if (!$this->setTagsToArticle($tags)) {
                Log::error('Не удалось добавить теги к статье', [
                    'article' => $this->_article,
                    'tags'    => $tags
                ]);

                return false;
            }
        }

        return true;
    }

    /**
     * Добавляет теги к статье
     *
     * @param array $tags
     * @return array
     */
    private function setTagsToArticle(array $tags): array
    {
        return $this->_article->tags()->sync($tags);
    }
}