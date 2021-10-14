<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            'theme_layout' => '2',
            'font_color' => 'color-7',
            'layout_type' => 'wide-layout',
            'layout_1' => '{"search_section":{"title":"Search Section","status":1},"popular_courses":{"title":"Popular Courses","status":1},"reasons":{"title":"Reasons why choose Neon LMS","status":1},"testimonial":{"title":"Testimonial","status":1},"latest_news":{"title":"Latest News, Courses","status":1},"sponsors":{"title":"Sponsors","status":1},"featured_courses":{"title":"Featured Courses","status":1},"teachers":{"title":"Teachers","status":1},"faq":{"title":"Frequently Asked Questions","status":1},"course_by_category":{"title":"Course By Category","status":1},"contact_us":{"title":"Contact us / Get in Touch","status":1}}',
            'layout_2' => '{"sponsors":{"title":"Sponsors","status":0},"popular_courses":{"title":"Popular Courses","status":0},"search_section":{"title":"Search Section","status":1},"latest_news":{"title":"Latest News, Courses","status":0},"featured_courses":{"title":"Featured Courses","status":1},"faq":{"title":"Frequently Asked Questions","status":1},"course_by_category":{"title":"Course By Category","status":1},"testimonial":{"title":"Testimonial","status":0},"teachers":{"title":"Teachers","status":1},"contact_us":{"title":"Contact us / Get in Touch","status":0}}',
            'layout_3' => '{"counters":{"title":"Counters","status":1},"latest_news":{"title":"Latest News, Courses","status":1},"popular_courses":{"title":"Popular Courses","status":1},"reasons":{"title":"Reasons why choose Neon LMS","status":1},"featured_courses":{"title":"Featured Courses","status":1},"teachers":{"title":"Teachers","status":1},"faq":{"title":"Frequently Asked Questions","status":1},"testimonial":{"title":"Testimonial","status":1},"sponsors":{"title":"Sponsors","status":1},"course_by_category":{"title":"Course By Category","status":1},"contact_us":{"title":"Contact us / Get in Touch","status":1}}',
            'layout_4' => '{"counters":{"title":"Counters","status":1},"popular_courses":{"title":"Popular Courses","status":1},"reasons":{"title":"Reasons why choose Neon LMS","status":1},"featured_courses":{"title":"Featured Courses","status":1},"course_by_category":{"title":"Course By Category","status":1},"teachers":{"title":"Teachers","status":1},"latest_news":{"title":"Latest News, Courses","status":1},"search_section":{"title":"Search Section","status":1},"faq":{"title":"Frequently Asked Questions","status":1},"testimonial":{"title":"Testimonial","status":1},"sponsors":{"title":"Sponsors","status":1},"contact_form":{"title":"Contact Form","status":1},"contact_us":{"title":"Contact us / Get in Touch","status":1}}',
            'counter' => '2',
            'total_students' => '1M+',
            'total_courses' => '1K+',
            'total_teachers' => '200+',
            'logo_b_image' => '1605778365-logo-1.png',
            'logo_w_image' => '1605773004-dswd-logo-white-1.png',
            'logo_white_image' => '1605773004-dswd-logo-white-1.png',
            'logo_popup' => '1605766305-logo-fav.png',
            'favicon_image' => '1605766305-logo-fav.png',
            'contact_data' => '[{"name":"short_text","value":"For inquiries and technical assistance, you may contact or visit our office:","status":1},{"name":"primary_address","value":"DSWD Field Office Cordillera (DSWD-CAR)","status":1},{"name":"secondary_address","value":"Califorinia, 88 Design Street, US","status":1},{"name":"primary_phone","value":"(100) 3434 55666","status":1},{"name":"secondary_phone","value":"(20) 3434 9999","status":1},{"name":"primary_email","value":"info@neonlms.com","status":1},{"name":"secondary_email","value":"mail@neonlms.info","status":1},{"name":"location_on_map","value":"<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d239.20758172612537!2d120.60088362020574!3d16.408500128285226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a143bb5008e5%3A0xe41697fb20b16bd!2sDSWD%20-%20CAR!5e0!3m2!1sen!2sph!4v1614736982313!5m2!1sen!2sph" width="800" height="600" style="border:0;" allowfullscreen=" loading="lazy"></iframe>","status":1}]',
            'footer_data' => '{"short_description":{"text":"The Capacity Building Section (CBS) serves as the talent development arm of the Department responsible in enhancing the competencies of intermediaries and stakeholders of DSWD in performing and achieving its goals as lead in the social welfare and social protection sector.","status":1},"section1":{"type":"2","status":0},"section2":{"type":"3","status":0},"section3":{"type":"4","status":0},"social_links":{"status":0,"links":[]},"newsletter_form":{"status":0},"bottom_footer":{"status":1},"copyright_text":{"text":"Copyright © 2020","status":1},"bottom_footer_links":{"status":1,"links":[{"label":"DSWD RICTMS","link":"https://car.dswd.gov.ph/"}]}}',
            'app.locale' => 'en',
            'app.display_type' => 'ltr',
            'app.currency' => 'PHP',
            'lesson_timer' => '1',
            'show_offers' => '0',
            'access.captcha.registration' => '1',
            'sitemap.chunk' => '500',
            'one_signal' => '0',
            'nav_menu' => '1',
            'commission_rate' => '0',
            'app.name' => 'DSWD CAR LXP',
            'app.url' => 'http://car-lms-svr',
            'google_analytics_id' => 'UA-193960343-1',
            'no-captcha.sitekey' => '6Lc9OesZAAAAAEKOYlwEZPsSI5b76OGu7-DAOvxb',
            'no-captcha.secret' => '6Lc9OesZAAAAAGAY9aodTIM4Z6jMGDZsMct4NDQ9',
            'onesignal_data' => '\N',
            'mail.from.name' => 'DSWD CAR LXP',
            'mail.from.address' => 'ictsupport.focar@dswd.gov.ph',
            'mail.driver' => 'SMTP',
            'mail.host' => 'smtp.gmail.com',
            'mail.port' => '587',
            'mail.username' => 'appnotifier.focar@dswd.gov.ph',
            'mail.password' => '',
            'mail.encryption' => 'tls',
            'services.stripe.key' => '\N',
            'services.stripe.secret' => '\N',
            'paypal.settings.mode' => 'sandbox',
            'paypal.client_id' => '\N',
            'paypal.secret' => '\N',
            'registration_fields' => '[{"name":"phone","type":"number"},{"name":"dob","type":"date"},{"name":"gender","type":"radio"},{"name":"address","type":"textarea"}]',
            'myTable_length' => '10',
            'access_registration' => '0',
            'mailchimp_double_opt_in' => '0',
            'access_users_change_email' => '0',
            'access_users_confirm_email' => '0',
            'access_captcha_registration' => '0',
            'access_users_requires_approval' => '0',
            'services.stripe.active' => '0',
            'paypal.active' => '0',
            'payment_offline_active' => '0',
            'backup.status' => '0',
            'retest' => '1',
            'onesignal_status' => '0',
            'section1' => '2',
            'section2' => '3',
            'section3' => '4',
            'icon' => 'fab fa-facebook-f',
            'swdforum.register' => '1',
            'swdforum_register' => '1',
            'mail_to_address' => 'ictsupport.focar@dswd.gov.ph',
            'mail_to_name' => 'Capacity Building Section',
        ];



        foreach ($data as $key => $value) {
            $key = str_replace('__', '.', $key);
            $config = \App\Models\Config::firstOrCreate(['key' => $key]);
            $config->value = $value;
            $config->save();
        }
    }
}
