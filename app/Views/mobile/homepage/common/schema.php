<?php
  helper('mydatafrontend');
  $general = get_general();
  // pre($general);
  if(isset($home)) {
?>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "<?php echo $general['homepage_company'] ?>",
    "alternateName": "<?php echo $general['homepage_brandname'] ?>",
    "url": "<?php echo $general['contact_website'] ?>",
    "logo": "<?php echo $general['homepage_logo'] ?>",
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "<?php echo $general['contact_phone'] ?>",
      "contactType": "",
      "areaServed": "VN",
      "availableLanguage": "Vietnamese"
    },
    "sameAs": [
      "<?php echo $general['social_twitter'] ?>",
      "<?php echo $general['social_facebook'] ?>",
      "<?php echo $general['social_google'] ?>",
      "<?php echo $general['social_youtube'] ?>",
      "<?php echo $general['social_linkedin'] ?>",
      "<?php echo $general['social_pinterest'] ?>",
      "<?php echo $general['contact_website'] ?>"
    ]
  }</script>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "<?php echo $general['homepage_company'] ?>",
    "image": "<?php echo $general['homepage_logo'] ?>",
    "@id": "<?php echo $general['contact_website'] ?>",
    "url": "<?php echo $general['contact_website'] ?>",
    "hasmap":"<?php echo $general['contact_map'] ?>",
    "telephone": "<?php echo $general['contact_phone'] ?>",
    "priceRange": "100000",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?php echo $general['contact_address'] ?>",
      "addressLocality": "<?php echo $general['contact_address'] ?>",
      "postalCode": "100000",
      "addressCountry": "VN"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": 20.9475592,
      "longitude": 105.7891151
    },
    "openingHoursSpecification": {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday"
      ],
      "opens": "00:00",
      "closes": "23:59"
    },
    "sameAs": [
      "<?php echo $general['social_facebook'] ?>",
      "<?php echo $general['social_google'] ?>",
      "<?php echo $general['social_youtube'] ?>",
      "<?php echo $general['social_linkedin'] ?>",
      "<?php echo $general['social_pinterest'] ?>",
      "<?php echo $general['social_twitter'] ?>",
      "<?php echo $general['contact_website'] ?>"
    ]
  }
  </script>
  <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "<?php echo $general['contact_website'] ?>",
        "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo $general['contact_website'] ?>",
        "query-input": "required name=search_term_string"
        }
     }
  </script>
<?php }else{ ?>

<script type="application/ld+json">{
    "@context": "https://schema.org/",
    "@type": "CreativeWorkSeries",
  "name": "<?php echo $general['seo_meta_title'] ?>",
        "description": "<?php echo $general['seo_meta_description'] ?>
",
        "url": "<?php echo $general['contact_website'] ?>",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.6",
        "ratingCount": "7",
        "bestRating": "5",
        "worstRating": "0"
    }
}</script>
<?php } ?>
