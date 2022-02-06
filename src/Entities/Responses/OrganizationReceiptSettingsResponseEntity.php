<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class OrganizationReceiptSettingsResponseEntity implements Arrayable
{
    use ResponseEntity;

    private ?string $text_global_header = null;
    private ?string $text_global_footer = null;
    private ?string $html_title = null;
    private ?string $email_subject = null;
    private ?string $html_global_header = null;
    private ?string $html_global_footer = null;
    private ?string $html_body_style = null;
    private ?string $html_receipt_style = null;
    private ?string $html_ruler_style = null;
    private ?string $html_light_block_style = null;
    private OrganizationResponseEntity $organization;

    /**
     * @return string
     */
    public function getTextGlobalHeader(): string
    {
        return $this->text_global_header;
    }

    /**
     * @return string
     */
    public function getTextGlobalFooter(): string
    {
        return $this->text_global_footer;
    }

    /**
     * @return string
     */
    public function getHtmlTitle(): string
    {
        return $this->html_title;
    }

    /**
     * @return string
     */
    public function getEmailSubject(): string
    {
        return $this->email_subject;
    }

    /**
     * @return string
     */
    public function getHtmlGlobalHeader(): string
    {
        return $this->html_global_header;
    }

    /**
     * @return string
     */
    public function getHtmlGlobalFooter(): string
    {
        return $this->html_global_footer;
    }

    /**
     * @return string
     */
    public function getHtmlBodyStyle(): string
    {
        return $this->html_body_style;
    }

    /**
     * @return string
     */
    public function getHtmlReceiptStyle(): string
    {
        return $this->html_receipt_style;
    }

    /**
     * @return string
     */
    public function getHtmlRulerStyle(): string
    {
        return $this->html_ruler_style;
    }

    /**
     * @return string
     */
    public function getHtmlLightBlockStyle(): string
    {
        return $this->html_light_block_style;
    }

    /**
     * @return OrganizationResponseEntity
     */
    public function getOrganization(): OrganizationResponseEntity
    {
        return $this->organization;
    }
}
