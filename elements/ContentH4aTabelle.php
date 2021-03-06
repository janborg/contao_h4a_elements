<?php

/*
 * Copyright (C) 2017 Janborg
 */

namespace H4aElements;

use StringUtil;
use Symfony\Component\Config\Definition\Exception\Exception;
use System;

/**
 * Class ContentH4aTabelle.
 *
 * @author Janborg
 */
class ContentH4aTabelle extends \ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_h4a_tabelle';

    /**
     * Generate the module.
     */
    protected function compile()
    {
        if (TL_MODE == 'BE') {
            $this->genBeOutput();
        } else {
            $this->genFeOutput();
        }
    }

    /**
     * Erzeugt die Ausgebe für das Backend.
     *
     * @return string
     */
    private function genBeOutput()
    {
        $this->strTemplate = 'be_wildcard';
        $this->Template = new \BackendTemplate($this->strTemplate);
        $this->Template->title = $this->headline;
        $this->Template->wildcard = 'liga_ID: '.$this->h4a_liga_ID.', Team Name: '.$this->my_team_name;
    }

    /**
     * Erzeugt die Ausgabe für das Frontend.
     *
     * @return string
     */
    private function genFeOutput()
    {
        $type = 'liga';
        $liga_url = Helper::getURL($type, $this->h4a_liga_ID);
        $strCacheFile = Helper::getCachedFile($this->h4a_liga_ID);

        // Load the cached result
        if (file_exists(TL_ROOT . '/' . $strCacheFile)) {
            $objFile = new \File($strCacheFile);
            if ($objFile->mtime > time() - 60 * 60 * 6) {
                $arrResult = json_decode($objFile->getContent(), true);
                $lastUpdate = $objFile->mtime;
            } else {
                $objFile->delete();
            }
        }

        // Cache the result
        if ($arrResult === null) {
            try {
                $arrResult = json_decode(file_get_contents($liga_url), true);
                $lastUpdate = time();
            } catch (\Exception $e) {
                System::log('h4a update failed: ' . $e->getMessage(), __METHOD__, TL_ERROR);
                $arrResult = array();
            }
            \File::putContent($strCacheFile, json_encode($arrResult));
        }

//        $arrResult = json_decode(file_get_contents($liga_url), true);
//        $lastUpdate = time();

        // Template ausgeben
        $this->Template = new \FrontendTemplate($this->strTemplate);
        $this->Template->class = 'ce_h4a_tabelle';
        $this->Template->teams = $arrResult[0]['dataList'];
        $this->Template->myTeam = $this->my_team_name;
        $this->Template->lastUpdate = $lastUpdate;
    }
}
