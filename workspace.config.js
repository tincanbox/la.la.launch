// This is shared-configuration between Gulp and Webpack
//
// ==== A Notion for Windows ====
// DONT use \ backslash as a path-separator.
// the backslashes will be escaped with \\
// and glob-module wont be able to find path properly.

module.exports = {

    serviceDir: 'service',

    docker: {
        user: 'laradock',
        group: 'laradock',
        file: './laradock/docker-compose.yml',
        shell: '/bin/bash',
        env: './laradock/.env',
    },

    laradock: {
        workspace: 'workspace',
        target: ['nginx', 'mysql', 'redis']
    },

    DEST: 'dist',

};