<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class ArticleBlock extends Element
{
    public function __construct(
        private string $title,
        private string $text,
        private array $articles,
        private string $link_url,
        private string $link_text,
    ) {}

    public function get_title(): string {
        return $this->title;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function get_articles(): array {
        return $this->articles;
    }

    public function get_link_url(): string {
        return $this->link_url;
    }

    public function get_link_text(): string {
        return $this->link_text;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/articleblock.html" );

        $template = str_replace( [
            "{TITLE}",
            "{TEXT}",
            "{ARTICLES}",
            "{LINK_URL}",
            "{LINK_TEXT}",
        ], [
            $this->get_title(),
            $this->get_text(),
            $this->render_articles(),
            $this->get_link_url(),
            $this->get_link_text(),
        ], $template );

        return $template;
    }

    private function render_articles(): string {
        $articles = $this->get_articles();

        $rendered = "";

        foreach( $articles as $article ) {
            $rendered .= $article->render();
        }

        return $rendered;
    }

    private function get_theme(): string {
        return "solid-state";
    }

    public function get_array(): array {
        $articles = [];

        foreach( $this->get_articles() as $article ) {
            $articles[] = $article->get_array();
        }

        return [
            "_type" => $this->get_element_type(),
            "title" => $this->get_title(),
            "text" => $this->get_text(),
            "articles" => $articles,
            "link_url" => $this->get_link_url(),
            "link_text" => $this->get_link_text(),
        ];
    }

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        $articles = [];

        foreach( $data->articles as $article ) {
            $articles[] = Article::from_json( $article );
        }

        return new ArticleBlock(
            title: $data->title,
            text: $data->text,
            articles: $articles,
            link_url: $data->link_url,
            link_text: $data->link_text,
        );
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::ArticleBlock;
    }
}
