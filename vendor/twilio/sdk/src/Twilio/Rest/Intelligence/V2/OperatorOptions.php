<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Intelligence
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Intelligence\V2;

use Twilio\Options;
use Twilio\Values;

abstract class OperatorOptions
{

    /**
     * @param string $availability Returns Operators with the provided availability type. Possible values: internal, beta, public, retired.
     * @param string $languageCode Returns Operators that support the provided language code.
     * @return ReadOperatorOptions Options builder
     */
    public static function read(
        
        string $availability = Values::NONE,
        string $languageCode = Values::NONE

    ): ReadOperatorOptions
    {
        return new ReadOperatorOptions(
            $availability,
            $languageCode
        );
    }

}


class ReadOperatorOptions extends Options
    {
    /**
     * @param string $availability Returns Operators with the provided availability type. Possible values: internal, beta, public, retired.
     * @param string $languageCode Returns Operators that support the provided language code.
     */
    public function __construct(
        
        string $availability = Values::NONE,
        string $languageCode = Values::NONE

    ) {
        $this->options['availability'] = $availability;
        $this->options['languageCode'] = $languageCode;
    }

    /**
     * Returns Operators with the provided availability type. Possible values: internal, beta, public, retired.
     *
     * @param string $availability Returns Operators with the provided availability type. Possible values: internal, beta, public, retired.
     * @return $this Fluent Builder
     */
    public function setAvailability(string $availability): self
    {
        $this->options['availability'] = $availability;
        return $this;
    }

    /**
     * Returns Operators that support the provided language code.
     *
     * @param string $languageCode Returns Operators that support the provided language code.
     * @return $this Fluent Builder
     */
    public function setLanguageCode(string $languageCode): self
    {
        $this->options['languageCode'] = $languageCode;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Intelligence.V2.ReadOperatorOptions ' . $options . ']';
    }
}

