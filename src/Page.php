<?php
namespace Unconv\CustomCms;
use PDO;

class Page
{
    public function __construct(
        protected ?int $id,
        protected string $name,
    ) {}

    /**
     * List of elements on page
     * @var Element[]
     */
    protected array $elements;

    public function add_element( Element $element ) {
        $this->elements[] = $element;
    }

    public function get_name(): string {
        return $this->name;
    }

    /**
     * Get elements included in page
     * @return Element[]
     */
    public function get_elements(): array {
        return $this->elements;
    }

    public function save( PDO $db ) {
        if( ! isset( $this->id ) ) {
            $stmt = $db->prepare(
                "INSERT INTO pages ( name ) VALUES( :name )"
            );

            $stmt->execute( [
                ":name" => $this->get_name(),
            ] );

            $this->id = $db->lastInsertId();

            foreach( $this->get_elements() as $element ) {
                $element->save( $db, $this->id );
            }
        }
    }

    public static function from_db( int $page_id, PDO $db ): static {
        $stmt = $db->prepare(
            "SELECT * FROM pages WHERE id = :id LIMIT 1"
        );

        $stmt->execute( [
            ":id" => $page_id,
        ] );

        $data = $stmt->fetch( PDO::FETCH_ASSOC );

        $page = new Page( $page_id, $data['name'] );

        $elements = $page->fetch_elements( $db );
        
        foreach( $elements as $element ) {
            $page->add_element( $element );
        }

        return $page;
    }

    private function fetch_elements( PDO $db ) {
        $stmt = $db->prepare(
            "SELECT * FROM elements WHERE page = :page"
        );

        $stmt->execute( [
            ":page" => $this->id,
        ] );

        $elements = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $element_list = [];

        foreach( $elements as $element ) {
            $json = json_decode( $element['data'] );
            $element_class = Element::get_element_class( $json );

            $object = $element_class::from_json( $json );
            $object->set_id( $element['id'] );

            $element_list[] = $object;
        }

        return $element_list;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/solid-state/elements/page.html" );

        $top_content = "";
        $wrapper = "";
        $footer = "";

        foreach( $this->get_elements() as $element ) {
            if( $element instanceof Footer ) {
                $footer .= $element->render();
            } elseif( $element instanceof Spotlight ) {
                $wrapper .= $element->render();
            } else {
                $top_content .= $element->render();
            }
        } 

        $template = str_replace( [
            "{TOP_CONTENT}",
            "{WRAPPER}",
            "{FOOTER}",
        ], [
            $top_content,
            $wrapper,
            $footer,
        ], $template );

        return $template;
    }
}
