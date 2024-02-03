<?php
// Add JSON-LD script to the header
function add_json_ld_to_header() {
    // Replace these placeholders with your actual data
    $url = get_the_permalink();
    $description = "";
    $header = "";
    $datePublished = get_the_date('c');
    $authorPageURL = get_the_permalink();
    $name = "";
    $imageURL = "";

    // JSON-LD data as an associative array
    $jsonLdData = array(
        "@context" => "https://schema.org/",
        "@type" => "Blog",
        "@id" => $url,
        "@url" => $url,
        "mainEntityOfPage" => $url,
        "name" => "Blog",
        "description" => $description,
        "publisher" => array(
            "@type" => "Organization",
            "@id" => $url,
            "name" => $name,
            "logo" => array(
                "@type" => "ImageObject",
                "@id" => $url,
                "url" => $url,
                "height" => "{252}",
                "width" => "{392}"
            )
        ),
        "blogPost" => array(
            array(
                "@type" => "BlogPosting",
                "@id" => $url,
                "mainEntityOfPage" => $url,
                "headline" => $header,
                "name" => $header,
                "datePublished" => $datePublished,
                "dateModified" => $datePublished,
                "author" => array(
                    "@type" => "Person",
                    "@id" => $authorPageURL,
                    "name" => $name
                ),
                "image" => array(
                    "@type" => "ImageObject",
                    "@id" => $imageURL,
                    "url" => $imageURL,
                    "height" => "{252}",
                    "width" => "{392}"
                ),
                "url" => $url
            )
        )
    );

    // Convert PHP array to JSON string with pretty-print
    $jsonString = json_encode($jsonLdData, JSON_PRETTY_PRINT);

    // Output the PHP code within the script tag
    echo '<script type="application/ld+json">' . PHP_EOL;
    echo $jsonString . PHP_EOL;
    echo '</script>';
}

// Hook the function to the wp_head action
// add_action('wp_head', 'add_json_ld_to_header');
