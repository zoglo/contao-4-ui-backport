import { Application } from '@hotwired/stimulus';
import { definitionForModuleAndIdentifier, identifierForContextKey } from '@hotwired/stimulus-webpack-helpers';

// Start the Stimulus application
const application = Application.start();
application.debug = process.env.NODE_ENV === 'development';

// Register all controllers with `contao--` prefix
const context = require.context('./controllers', true, /\.js$/);
application.load(context.keys()
    .map((key) => {
        const identifier = identifierForContextKey(key);
        if (identifier) {
            return definitionForModuleAndIdentifier(context(key), `contao--${ identifier }`);
        }
    }).filter((value) => value)
);
