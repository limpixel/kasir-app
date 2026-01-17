import { Head } from "@inertiajs/react";

export default function LoungeLayout({ children }) {
    return (
        <>
            <Head>
                <title>Lounge</title>

                <meta charSet="utf-8" />
                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1"
                />

                <link rel="stylesheet" href="/css/vendor.css" />
                <link rel="stylesheet" href="/css/styles.css" />

                <link
                    rel="apple-touch-icon"
                    sizes="180x180"
                    href="/images/apple-touch-icon.png"
                />
                <link
                    rel="icon"
                    type="image/png"
                    sizes="32x32"
                    href="/images/favicon-32x32.png"
                />
                <link
                    rel="icon"
                    type="image/png"
                    sizes="16x16"
                    href="/images/favicon-16x16.png"
                />

                <script
                    dangerouslySetInnerHTML={{
                        __html: `
                        document.documentElement.classList.remove('no-js');
                        document.documentElement.classList.add('js');
                    `,
                    }}
                />
            </Head>

            {children}

            {/* JS Script Link */}
            <script src="/js/plugins.js"></script>
            <script src="/js/main.js"></script>
        </>
    );
}
