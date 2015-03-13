<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since    2.0.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link     http://www.quickappscms.org
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Installer\Shell;

use Cake\Console\Shell;
use QuickApps\Core\Plugin;

/**
 * Shell for themes management.
 *
 */
class ThemesShell extends Shell
{

    /**
     * Contains tasks to load and instantiate.
     *
     * @var array
     */
    public $tasks = [
        'Installer.PluginInstall',
        'Installer.PluginUninstall',
        'Installer.ThemeActivation',
    ];

    /**
     * Removes the welcome message.
     *
     * @return void
     */
    public function startup()
    {
    }

    /**
     * Gets the option parser instance and configures it.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser
            ->description('Database maintenance commands.')
            ->addSubcommand('install', [
                'help' => 'Install a new theme.',
                'parser' => $this->PluginInstall->getOptionParser(),
            ])
            ->addSubcommand('uninstall', [
                'help' => 'Uninstalls an existing theme.',
                'parser' => $this->PluginUninstall->getOptionParser(),
            ])
            ->addSubcommand('change', [
                'help' => 'Change theme in use.',
                'parser' => $this->ThemeActivation->getOptionParser(),
            ]);

        return $parser;
    }

    /**
     * Override main() for help message hook
     *
     * @return void
     */
    public function main()
    {
        $this->out(__d('installer', '<info>Themes Shell</info>'));
        $this->hr();
        $this->out(__d('installer', '[I]nstall new theme'));
        $this->out(__d('installer', '[R]emove an existing theme'));
        $this->out(__d('installer', '[C]hange site theme'));
        $this->out(__d('installer', '[H]elp'));
        $this->out(__d('installer', '[Q]uit'));

        $choice = strtolower($this->in(__d('installer', 'What would you like to do?'), ['I', 'R', 'C', 'H', 'Q']));
        switch ($choice) {
            case 'i':
                $this->_install();
                break;
            case 'r':
                $this->_uninstall();
                break;
            case 'c':
                $this->_change();
                break;
            case 'h':
                $this->out($this->OptionParser->help());
                break;
            case 'q':
                return $this->_stop();
            default:
                $this->out(__d('installer', 'You have made an invalid selection. Please choose a command to execute by entering I, R, C, H, or Q.'));
        }
        $this->hr();
        $this->main();
    }

    /**
     * Activator task.
     *
     * @return bool
     */
    public function change()
    {
        return $this->ThemeActivation->main();
    }

    /**
     * Install task.
     *
     * @return bool
     */
    public function install()
    {
        return $this->PluginInstall->main();
    }

    /**
     * Uninstall task.
     *
     * @return bool
     */
    public function uninstall()
    {
        return $this->PluginUninstall->main();
    }

    /**
     * Installs a new theme.
     *
     * @return void
     */
    protected function _install()
    {
        $message = __d('installer', "Please provide a theme source, it can be either an URL or a filesystem path to a ZIP/directory within your server?\n[Q]uit");

        while (true) {
            $source = $this->in($message);
            if (strtoupper($source) === 'Q') {
                $this->err(__d('installer', 'Installation aborted'));
                break;
            } else {
                $this->out(__d('installer', 'Starting installation...'), 0);
                $task = $this->dispatchShell("Installer.plugins install -s \"{$source}\" --theme -a");

                if ($task === 0) {
                    $this->_io->overwrite(__d('installer', 'Starting installation... successfully installed!'), 2);
                    $this->out();
                    break;
                } else {
                    $this->_io->overwrite(__d('installer', 'Starting installation... failed!'), 2);
                    $this->out();
                }
            }
        }

        $this->out();
    }

    /**
     * Removes an existing theme.
     *
     * @return void
     */
    protected function _uninstall()
    {
        $allThemes = Plugin::get()
            ->filter(function ($plugin) {
                return $plugin->isTheme;
            })
            ->toArray();
        $index = 1;
        $this->out();
        foreach ($allThemes as $plugin) {
            $allThemes[$index] = $plugin;
            $this->out(__d('installer', '[{index, number}] {name}', ['index' => $index, 'name' => $plugin->human_name]));
            $index++;
        }
        $this->out();

        $message = __d('installer', "Which theme would you like to uninstall?\n[Q]uit");
        while (true) {
            $in = trim($this->in($message));
            if (strtoupper($in) === 'Q') {
                $this->err(__d('installer', 'Operation aborted'));
                break;
            } elseif (intval($in) < 1 || !isset($allThemes[intval($in)])) {
                $this->err(__d('installer', 'Invalid option'));
            } else {
                $plugin = Plugin::get($allThemes[$in]->name());
                $this->hr();
                $this->out(__d('installer', '<info>The following theme will be uninstalled</info>'));
                $this->hr();
                $this->out(__d('installer', 'Name:        {0}', $plugin->name));
                $this->out(__d('installer', 'Description: {0}', $plugin->composer['description']));
                $this->out(__d('installer', 'Path:        {0}', $plugin->path));
                $this->hr();
                $this->out();

                $confirm = $this->in(__d('installer', 'Please type in "{0}" to uninstall', $allThemes[$in]->name));
                if ($confirm === $allThemes[$in]->name) {
                    $task = $this->dispatchShell("Installer.plugins uninstall -p {$allThemes[$in]->name}");

                    if ($task === 0) {
                        $this->out(__d('installer', 'Plugin uninstalled!'));
                        Plugin::dropCache();
                    } else {
                        $this->err(__d('installer', 'Plugin could not be uninstalled.'), 2);
                        $this->out();
                    }
                } else {
                    $this->err(__d('installer', 'Confirmation failure, operation aborted!'));
                }
                break;
            }
        }

        $this->out();
    }

    /**
     * Switch site's theme.
     *
     * @return void
     */
    protected function _change()
    {
        $disabledThemes = Plugin::get()
            ->filter(function ($theme) {
                return $theme->isTheme && !in_array($theme->name, [option('front_theme'), option('back_theme')]);
            })
            ->toArray();

        if (!count($disabledThemes)) {
            $this->err(__d('installer', '<info>There are no disabled themes!</info>'));
            $this->out();
            return;
        }

        $index = 1;
        $this->out();
        foreach ($disabledThemes as $theme) {
            $disabledThemes[$index] = $theme;
            $this->out(__d('installer', '[{index, number, integer}] {name} [{theme_type, select, front{frontend} other{backend}}]', ['index' => $index, 'name' => $theme->human_name, 'theme_type' => ($theme->isAdmin ? 'back' : 'front')]));
            $index++;
        }
        $this->out();

        $message = __d('installer', "Which theme would you like to activate?\n[Q]uit");
        while (true) {
            $in = $this->in($message);
            if (strtoupper($in) === 'Q') {
                $this->err(__d('installer', 'Operation aborted'));
                break;
            } elseif (intval($in) < 1 || !isset($disabledThemes[intval($in)])) {
                $this->err(__d('installer', 'Invalid option'));
            } else {
                $task = $this->dispatchShell("Installer.themes change -t {$disabledThemes[$in]->name}");

                if ($task === 0) {
                    $this->out(__d('installer', 'Theme changed!'));
                    Plugin::dropCache();
                } else {
                    $this->err(__d('installer', 'Theme could not be changed.'), 2);
                    $this->out();
                }
                break;
            }
        }

        $this->out();
    }
}
