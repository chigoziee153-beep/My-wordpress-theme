(function (wp) {
  'use strict';
  if (!wp || !wp.blocks || !wp.element || !wp.blockEditor || !wp.components) return;

  const e = wp.element.createElement;
  const useBlockProps = wp.blockEditor.useBlockProps;
  const InspectorControls = wp.blockEditor.InspectorControls;
  const PanelBody = wp.components.PanelBody;
  const TextControl = wp.components.TextControl;
  const TextareaControl = wp.components.TextareaControl;
  const schema = window.NYDLAHomeBlockDefinitions || {};

  Object.keys(schema).forEach(function (slug) {
    const definition = schema[slug];
    const attributes = {};
    definition.fields.forEach(function (field) {
      attributes[field.key] = { type: 'string', default: field.default };
    });

    wp.blocks.registerBlockType('nydla/' + slug, {
      apiVersion: 2,
      title: definition.title,
      description: definition.description,
      category: 'design',
      icon: definition.icon || 'welcome-widgets-menus',
      attributes: attributes,
      supports: { html: false, anchor: false },
      edit: function (props) {
        const a = props.attributes;
        const preview = [
          e('span', { className: 'nydla-editor-eyebrow', key: 'eyebrow' }, a.eyebrow || 'NYDLA'),
          e('h2', { key: 'title' }, a.title || definition.title),
          e('p', { key: 'description' }, a.description || definition.description)
        ];

        if (slug === 'journey') {
          preview.push(e('div', { className: 'nydla-editor-cards nydla-editor-journey-cards', key: 'steps' }, [1, 2, 3].map(function (n) {
            return e('div', { key: n }, a['stage' + n + 'Title'] || 'Stage ' + n);
          })));
        }
        if (slug === 'features') {
          preview.push(e('div', { className: 'nydla-editor-cards', key: 'cards' }, [1, 2, 3, 4].map(function (n) {
            return e('div', { key: n }, a['card' + n + 'Title'] || 'Feature ' + n);
          })));
        }
        if (slug === 'hero') {
          preview.push(e('div', { className: 'nydla-editor-actions', key: 'actions' }, a.primaryLabel + '  ↗    /    ' + a.secondaryLabel));
          preview.push(e('div', { className: 'nydla-editor-art', key: 'art' }, a.panelWord1 + ' ' + a.panelWord2 + ' ' + a.panelWord3));
        }
        if (slug === 'insights') {
          preview.push(e('p', { className: 'nydla-editor-note', key: 'note' }, 'Your latest three published posts are loaded automatically on the website.'));
        }

        return e(wp.element.Fragment, null,
          e(InspectorControls, null,
            e(PanelBody, { title: 'Edit NYDLA section', initialOpen: true },
              definition.fields.map(function (field) {
                const key = field.key;
                const common = {
                  key: key,
                  label: field.label,
                  value: a[key] || '',
                  onChange: function (value) {
                    const next = {};
                    next[key] = value;
                    props.setAttributes(next);
                  }
                };
                if (field.multiline) return e(TextareaControl, common);
                if (field.url) common.type = 'url';
                return e(TextControl, common);
              })
            )
          ),
          e('section', useBlockProps({ className: 'nydla-editor-section nydla-editor-' + slug }), preview)
        );
      },
      save: function () { return null; }
    });
  });
})(window.wp);
