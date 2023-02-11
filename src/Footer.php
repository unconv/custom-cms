<?php
namespace Unconv\CustomCms;

class Footer extends Element
{
    public function __construct(
        private string $heading,
        private string $text,
        private string $address,
        private string $phone,
        private string $email,
        private array $links,
        private string $copyright,
        private ?Form $form = null,
    ) {}

    public function get_heading(): string {
        return $this->heading;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function get_address(): string {
        return nl2br( $this->address );
    }

    public function get_phone(): string {
        return $this->phone;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function get_copyright(): string {
        return $this->copyright;
    }

    /**
     * Get footer links
     * @return FooterLink[]
     */
    public function get_links(): array {
        return $this->links;
    }

    public function get_form(): Form {
        return $this->form;
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Footer;
    }
}
