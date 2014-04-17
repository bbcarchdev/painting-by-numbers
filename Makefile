## Author: Mo McRoberts <mo.mcroberts@bbc.co.uk>
##
## Copyright (c) 2014 BBC
##
##  Licensed under the Apache License, Version 2.0 (the "License");
##  you may not use this file except in compliance with the License.
##  You may obtain a copy of the License at
##
##      http://www.apache.org/licenses/LICENSE-2.0
##
##  Unless required by applicable law or agreed to in writing, software
##  distributed under the License is distributed on an "AS IS" BASIS,
##  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
##  See the License for the specific language governing permissions and
##  limitations under the License.

## Tunables

XSLTPROC ?= xsltproc

## The main document

DOC = index.html
PDF = painting-by-numbers.pdf
TEMPLATE = templates/index.phtml

STYLE = style.css
STYLETEMPLATE = templates/style.pcss

PSTYLE = print.css
PSTYLETEMPLATE = templates/print.pcss

## A sample book
BOOK = book.xml
BOOKPDF = book.pdf
BOOKHTML = book.html
BOOKTEMPLATE = templates/book.pxml								

## A sample manual page
MANPAGE = manpage.xml
MANPAGEPDF = manpage.pdf
MANPAGEHTML = manpage.html

all: $(DOC) $(STYLE) $(PSTYLE) $(BOOKHTML) $(MANPAGEHTML)

pdf: $(PDF) $(BOOKPDF)

## All of the source samples
SAMPLES = \
	components/logo-variants.php \
	components/colours.php \
	components/header.css components/header-print.css \
	components/globalnav.html components/globalnav.css components/globalnav-print.css \
	components/masthead.css components/masthead-print.css components/masthead-override.css \
	components/innercover.css components/innercover-print.css \
	components/legalnotice.html components/legalnotice.xml \
	components/frontmatter.html components/frontmatter.xml \
	components/footer.css \
	components/body-text.html components/body-text.css components/body-text-print.css components/body-text.css.html \
	components/headings.html components/headings.css components/headings.css.html components/headings-example.html components/headings-example.xml \
	components/lists.css \
	components/ol.html components/ol.css components/ol.xml \
	components/ul.html components/ul.xml \
	components/dl.css components/dl.html components/dl.xml \
	components/toc.html components/toc.css \
	components/hr.html components/hr.css \
	components/code-sample.html components/code-sample.xml components/samp-sample.html components/samp-sample.xml components/code-sample.css components/code-sample-print.css \
	components/table.html components/table.css \
	components/figure.html components/figure.css \
	components/callout.html components/callout.xml components/callout.css \
	components/example.html components/example.xml components/example.css components/example-print.css \
	components/blockquote.html components/blockquote.xml components/blockquote.css \
	components/footnote.html components/footnote.css \
	components/form.html \
	components/link-simulated.html components/link.css components/link-print.css \
	components/em.html components/em.css \
	components/abbr.html components/abbr.xml components/abbr.css components/abbr-print.css \
	components/code-literals.html components/code-literals.xml components/code-literals.css \
	components/q.html components/q.css \
	components/colours.php

## All of the XSLT
XSLT = docbook-html5/docbook-html5.xsl docbook-html5/doc.xsl docbook-html5/block.xsl docbook-html5/inline.xsl docbook-html5/toc.xsl
	
$(DOC): tools/generate.php $(TEMPLATE) $(SAMPLES)
	php -f tools/generate.php $(TEMPLATE) > $(DOC)

$(STYLE): tools/generate.php $(STYLETEMPLATE) $(SAMPLES)
	php -f tools/generate.php $(STYLETEMPLATE) > $(STYLE)

$(PSTYLE): tools/generate.php $(PSTYLETEMPLATE) $(SAMPLES)
	php -f tools/generate.php $(PSTYLETEMPLATE) > $(PSTYLE)

$(BOOK): tools/generate.php $(BOOKTEMPLATE) $(SAMPLES)
	php -f tools/generate.php $(BOOKTEMPLATE) > $(BOOK)

$(BOOKHTML): $(BOOK) $(BOOKSTYLES) $(XSLT)
	$(XSLTPROC) -nonet --xinclude \
		--param "html.linksfile" "'`pwd`/templates/docbook-styles.xml'" \
		--param "html.ie78css" "'ie78.css'" \
		docbook-html5/docbook-html5.xsl $(BOOK) > $(BOOKHTML)

$(MANPAGEHTML): $(MANPAGE) $(BOOKSTYLES) $(XSLT)
	$(XSLTPROC) -nonet --xinclude \
		--param "html.linksfile" "'`pwd`/templates/docbook-styles.xml'" \
		--param "html.ie78css" "'ie78.css'" \
		docbook-html5/docbook-html5.xsl $(MANPAGE) > $(MANPAGEHTML)	

$(PDF): $(DOC) $(STYLE) $(PSTYLE)
	wkpdf --print-background --stylesheet-media print --paper a4 --orientation portrait --ignore-http-errors --source $< --output $@

$(BOOKPDF): $(BOOKHTML) $(STYLE) $(PSTYLE)
	wkpdf --print-background --stylesheet-media print --paper a4 --orientation portrait --ignore-http-errors --source $< --output $@
