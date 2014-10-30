## Author: Mo McRoberts <mo.mcroberts@bbc.co.uk>
##
## Copyright (c) 2014 BBC
##
## Licensed under the terms of the Open Government Licence, version 2.0.
## You may obtain a copy of the license at:
##
## https://www.nationalarchives.gov.uk/doc/open-government-licence/version/2/

SUBDIRS = components images logo templates tools

pbnhtdoc_DATA = index.html book.html manpage.html \
	book.xml manpage.xml \
	book.pdf manpage.pdf \
	style.css print.css

dist_pbnhtdoc_DATA = ie78.css sample.css local.css

# All of the source components used to generate the HTML
COMPONENTS = \
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

index.html: $(srcdir)/templates/index.phtml $(srcdir)/tools/generate.php $(COMPONENTS)
	$(PHP) -f $(srcdir)/tools/generate.php $< > $@

style.css: $(srcdir)/templates/style.pcss $(srcdir)/tools/generate.php $(COMPONENTS)
	$(PHP) -f $(srcdir)/tools/generate.php $< > $@

print.css: $(srcdir)/templates/print.pcss $(srcdir)/tools/generate.php $(COMPONENTS)
	$(PHP) -f $(srcdir)/tools/generate.php $< > $@

book.html: book.xml $(XSLTFILES) $(NAV) $(LINKS)
	$(XML2HTML) $<

book.pdf: book.html 
	$(HTML2PDF) $<
 
manpage.html: manpage.xml $(XSLTFILES) $(NAV) $(LINKS)
	$(XML2HTML) $<

manpage.pdf: manpage.html
	$(HTML2PDF) $<
