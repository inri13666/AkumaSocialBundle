# AkumaSocialBundle

#Facebook
    https://developers.facebook.com/docs/reference/php/4.0.0

#Google+
    https://developers.google.com/+/quickstart/php
    https://developers.google.com/api-client-library/php/guide/aaa_overview
#Microsoft Live
    https://msdn.microsoft.com/en-us/library/bb676633.aspx
    https://account.live.com/developers/applications/index
    http://www.microsoft.com/en-us/download/details.aspx?id=7843 <== SDK HERE

#parameters.yml.dist:
    parameters:
        #Akuma Social Params
        #Facebook
        facebook_id: ''
        facebook_secret: ''
        facebook_scopes: [email, public_profile]
        #Google
        google_id: ''
        google_secret: ''
        google_scopes: [email]

#config.yml:
    akuma_social:
        facebook:
            app_id: %facebook_id%
            app_secret: %facebook_secret%
            app_scopes: %facebook_scopes%
        google:
            app_id: %google_id%
            app_secret: %google_secret%
            app_scopes: %google_scopes%

#routing.yml:
    akuma_social:
        resource: "@AkumaSocialBundle/Resources/config/routing-all.yml"
        prefix:   /

#security.yml:
    security:
        encoders:
            FOS\UserBundle\Model\UserInterface: plaintext

        providers:
            chainprovider:
                chain:
                    providers:
                        - fos_userbundle
                        - akuma_social_facebook
                        - akuma_social_google
            fos_userbundle:
                id: fos_user.user_provider.username
            akuma_social_facebook:
                id: fos_user.user_provider.username
            akuma_social_google:
                id: fos_user.user_provider.username

        firewalls:
            main:
                pattern: ^/

                akuma_social_facebook:
                    provider: akuma_social_facebook
                    login_path: /user/login
                    #TODO Add route name support
                    check_path: /facebook/connect
                    default_target_path: /

                akuma_social_google:
                    provider: akuma_social_google
                    login_path: /user/login
                    #TODO Add route name support
                    check_path: /google/connect
                    default_target_path: /

                form_login:
                      provider: fos_userbundle
                      csrf_provider: form.csrf_provider
                      login_path:     /user/login
                      use_forward:    false
                      check_path:     /user/login_check
                      failure_path:   null
                logout:
                    path: /user/logout
                anonymous: ~
                remember_me:
                      key:      "%secret%"
                      lifetime: 4147200
                      path:     /
                      domain:   ~
            dev:
                pattern: ^/(_(profiler|wdt|error)|css|images|js)/
                security: false

            default:
                anonymous: ~

        access_control:
            - { path: ^/user/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
    #        - { path: ^/secured, role: ROLE_USER }

