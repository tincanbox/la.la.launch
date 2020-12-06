{ // FIXes

  // Silencing deprecation error of Domain class.
  // https://github.com/gulpjs/gulp/issues/2460
  const { emitWarning } = process;
  process.emitWarning = (warning, type, code, ...extraArgs) => code !== 'DEP0097' && emitWarning(warning, type, code, ...extraArgs);

};

import * as path from 'path';
import { promises as fsp } from 'fs';
import { parallel, series } from 'gulp';
import { spawn as spawn_default } from 'child_process';
import yargs from 'yargs/yargs';
import { terminal as term } from "terminal-kit";

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

const SEQUENCE = { parallel , series };
const CONFIG = require('./workspace.config.js');
const argv = yargs(process.argv).argv;

const spawn = function spawn_override() {
  // console.log('spawn called');
  // console.log(arguments);
  return spawn_default.apply(this, arguments);
};

/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * Helpers
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

/*
 * bind (
 *   type:string
 *   ...cbs:...callbable
 * )
 */
function bind(type, ...cbs) {
  return SEQUENCE[type](cbs.map((f) => {
    if(typeof f == "function") return (async (done) => await f(CONFIG, done));
    else return f;
  }));
}

/**
 * @param {*} args 
 */
function cmd(args) {
  let cmd = args.shift();

  term('^wRunning:^ ' + '^y' + cmd + ' ' + args.join(' ') + '^ ');
  term('\n');

  return new Promise((res, rej) => {
    try {
      let proc = spawn(cmd, args);
      proc.on('spawn', (e) => {
        console.log('spawned', e);
      });
      proc.on('data', (data) => {
        console.log('data', data);
      });
      proc.on('error', (err) => {
        term.red('ProcError: ' + err + '\n');
        rej(new Error('DockerExecutionError: ' + err));
      });
      proc.stdout.on('data', (data) => {
        let out = data.toString().trim();
        out.length && term.blue(out + '\n');
      });
      proc.stderr.on('data', (data) => {
        let out = data.toString().trim().replace(/^\s+/, '').trim();
        if (out.length) {
          if (out.match(/^([A-Za-z]+)ing /)) {
            // Docker NNNing descriptions.
            term.blue(out + '\n');
          } else {
            term.red('STDERR: ' + out + '\n');
          }
        }
      });
      proc.on('close', (code) => {
        if (code == 0) {
          term.yellow('🎉 Process execution done!!\n');
          res(code);
        } else {
          rej(new Error('DockerExecutionError: ' + code));
        }
      });
    } catch (e) {
      term.red('-------------------------------------------------------\n');
      term.red(e.message + '\n');
      console.error(e);
    }
  });
}

/**
 * list all dir content.
 */
async function dir(p) {
  return (await fsp.readdir(p)).reduce(async (m, v) => {
    let stack = await m, relp = p + '/' + v, stat = await fsp.stat(relp);
    (stat.isDirectory())
      ? stack = stack.concat(await dir(relp))
      : stack.push(relp)
    return [...stack];
  }, []);
}

async function copy(src, dest){
  let content = await dir(src);
  return await Promise.all(content.map(v => {
    let d = v.replace(src, dest);
    term.yellow(['Coping', v, 'to', d, '\n'].join(' '));
    return fsp.mkdir(path.dirname(d), { recursive: true })
           .then(() => { fsp.copyFile(v, d) })
  }));
}

/**
 * docker(
 *   type:string = Type name.
 *     - 'run'     = Equiv: docker-compose [defaults] your argsss
 *     - 'command' = Equiv: docker-compose [defaults] exec -T --user=you your_workspace /your/shell -c your command
 *     - 'shell'   = Equiv: docker-compose [defaults] exec -T --user=you your_workspace /your/shell some thing
 *     - 'exec'    = Equiv: docker-compose [defaults] exec -T --user=you your_workspace your argsss
 *   ...args:mixed = Arguments for command its self.
 * )
 */
function docker(type, ...args) {
  let command_component = generate_docker_command(type, ...args);
  return cmd(command_component);
}

/**
 * generate_docker_command(
 *   type:string = Type Name
 *   ...args:mixed = Arguments for command.
 * ) -> string
 */
function generate_docker_command(type, ...args) {
  let DC = CONFIG.docker;
  let compose_file = path.resolve(DC.file);
  let env_file = path.resolve(DC.env);
  let BAS_CMD = 'docker-compose';
  let DEF_ARG = ['-f', compose_file, '--env-file=' + env_file, '--no-ansi', '--log-level', 'ERROR'];
  let EXC_ARG = ['exec', '-T', '--user=' + DC.user, CONFIG.laradock.workspace];
  let CMD_ARG = [].concat(DEF_ARG);

  switch(type){
    case 'run':
      CMD_ARG = CMD_ARG.concat(args);
      break;
    case 'exec':
      CMD_ARG = CMD_ARG.concat(EXC_ARG).concat(args);
      break;
    case 'shell':
      CMD_ARG = CMD_ARG.concat(['exec', '--user=' + DC.user, CONFIG.laradock.workspace]);
      CMD_ARG.push(DC.shell);
      CMD_ARG = CMD_ARG.concat(args);
      break;
    case 'command':
      CMD_ARG = CMD_ARG.concat(EXC_ARG);
      CMD_ARG.push(DC.shell, '-c');
      CMD_ARG = CMD_ARG.concat(args.join(' '));
      break;
    default:
      throw new Error('Invalid Run Configuration');
  }

  return [BAS_CMD].concat(CMD_ARG);
}


export {
  CONFIG,
  argv, 
  term,
  bind, dir, copy,
  docker,
  generate_docker_command
};
