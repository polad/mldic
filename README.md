MLDIC API
=========

MLDIC API has 3 entry points:

/entries
/languages
/users

Entries
-------

Each entry has a following structure:
<pre>
    {
        id: 123,
        phrase: "abdominal cavity",
        language: {
            id: 1,
            code: "en",
            name: "English"
        },
        createdBy: {
            id: 345,
            email: "someone@email.com",
            firstName: "Some",
            lastName: "One"
        },
        createdDate: "280920111015", (*not certain about the date format yet)
        modifiedBy: {
            id: 987,
            email: "anotherdude@blah.com",
            firstName: "Another",
            lastName: "Dude"
        },
        modifiedDate: "290920111034",
        descriptions: [
            {...},
            ...
        ],
        synonyms: [ {
                id: 89743,
                phrase: "some other synonym",
                link: {
                    rel: "...",
                    href: "http://api.url...com/entries/some other synonym/en"
                }
            },
            ...
        ],
        translations: [ {
                id: 14,
                code: "hu",
                name: "Hungarian",
                entries: [ {
                        id: 92343,
                        phrase: "blah blah",
                        link: {
                            rel: "...",
                            href: "http://api.url...com/entries/blah blah/fr"
                        }
                    },
                    ...
                ]
            },
            ...
        ]
    }
</pre>

Each entry is unque in terms of Phrase+Language combination. In other words there could onyl be one entry with a given phrase in a given language (e.g. there would be only one "abdominal cavity" entry for english language). Phrase can consist of 1+ words.

Here are some request examples for the Entry resources:

* `HTTP GET: /entries/abdomen` - Will return all entries with a phrase *"abdomen"* in all languages.
* `GET: /entries/abdomen/en` - Return a single entry *"abdomen"* in english. If not found status code 404.
* `GET: /entries/acut*` - Return all entries where phrase starts with *"acut"* in all languages.
* `GET: /entries/*acut/hu` - Return all entries where phrase ends with *"acut"* in hungarian language.
* `GET: /entries/~blah` - Return all entries where phrase is similar to *"blah"* (useful when not certain about the correct spelling).
* `GET: /entries/~slovo/ru` - Return all entries with phrase similar to *"slovo"* in russian. *(e.g. slava, sleva, slovo)*
