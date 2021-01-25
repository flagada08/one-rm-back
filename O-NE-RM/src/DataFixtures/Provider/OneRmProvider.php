<?php

namespace App\DataFixtures\Provider;

class OneRmProvider
{
    //Nom des exercices
    private $ExerciseName = [
        'Clean and jerk',
        'Deadlift',
        'sumo deadlift ',
        'Front squat',
        'Back squat',
        'strictpress',
        'Overhead squat',
        'Power clean',
        'Push press',
        'Snatch',
        'squat clean',
        'Butterfly pull-up',
        'Sit-up',
        'Push-up',
        'Hand-stand push-up',
        'Wall-ball',
        'Kettlebell-swing',
    ];

    // Difficulté des exercices
    private $ExerciseDiffuclty = [
        '3',
        '1',
        '1',
        '2',
        '2',
        '3',
        '5',
        '4',
        '2',
        '3',
        '4',
        '4',
        '1',
        '1',
        '5',
        '1',
        '1',
    ];

    //Conseils de realisation
    private $advice = [
        "Le 'Clean and Jerk' ou Epaulé-Jeté est un mouvement olympique d'haltérophilie.",
        "Il permet en deux mouvements d'amener une barre très lourde au dessus de la tête.",
        "Le soulevé de terre (deadlift en anglais) est un mouvement de powerlifting très efficace qui permet de travailler quasiment tous les grands groupes musculaires du corps.",
        "Certainement la variante la plus connue, extrêmement plébiscitée des Powerlifters, vous savez, ces grands messieurs très musclés qui soulèvent très lourd ! La différence majeure entre un soulevé de terre classique et un sumo deadlift réside dans la position des pieds, ceux-ci sont espacés plus largement, à la manière des sumos. L’avantage principal, c’est que la barre a moins de chemin à parcourir jusqu’au point culminant du mouvement, on peut donc charger plus ! Mais ce n’est pas tout, il y a aussi une petite variante de cette variante ! Le sumo deadlift pull, qui consiste à ajouter en fin de mouvement un tirage de la barre en direction du menton ! Ils sont fous ces sumos !",
        "Le front squat est une variante de l'exercice de squat traditionnel qui consiste à réaliser le mouvement avec la barre devant soi. Il permet de travailler principalement les quadriceps (droit fémoral, vaste intermédiaire, vaste médial et latéral).",
        "Le back squat en Crossfit correspond à un exercice de base pour développer en priorité les quadriceps mais aussi les muscles fessiers et les adducteurs. ... Cet exercice se pratique en position debout avec un écartement des pieds équivalent à la largeur du bassin.",
        "Le strict press, également appelé shoulder press, est un exercice purement de force et de musculation. Plus précisément, il cible les muscles des épaules et développe la force de poussée au-dessus de la tête. ... La barre doit se positionner directement au-dessus de vos épaules.",
        "Genoux fléchis, le dos bien droit, l'overhead squat en Crossfit consiste à porter une barre, chargée de disques de fonte, au-dessus de sa tête en conservant les bras écartés et tendus. ... Il sollicite alors les muscles profonds du dos, condition sinequanone pour que la barre n'oscille pas.",
        "Le Power Clean ou Clean est l'une des meilleures méthodes pour gagner en force et en masse musculaire dans l'univers du Crossfit et d'autres programmes de salle de sport. Il s'agit d'un exercice de puissance qui consiste à soulever une barre du sol vers l'avant des épaules, avec l'aide de tout le corps.",
        "Un incontournable des metcons, le push press ressemble au strict press, mais fait appel au bas du corps. Vous devez initier un push press avec un dip dans les jambes, puis transférer cet élan dans vos bras pour soulever la barre des épaules vers une position verrouillée overhead.",
        "L'arraché en musculation (Snatch) est un des deux mouvements techniques de la musculation et plus spécifiquement de l'haltérophilie, qui consiste à soulever une barre comprenant des charges diverses, se trouvant au sol, au-dessus de la tête, en un seul et même mouvement vif. On peut aisément parler de propulsion.",
        "Le squat clean est un mélange de power clean et de squat il consiste à tirer la barre trés fort vers le haut tout en chutant en squat pour réceptionner la bar",
        "a remplir",
        "a remplir",
        "a remplir",
        "a remplir",
        "a remplir",
        "a remplir",
    ];

 
    /**
     * Retourne un exercice
     */
    public function ExerciseName($i)
    {
        return $this->ExerciseName[$i];
    }

    /**
     * Retourne une diffculté
     */
    public function difficulty($i)
    {
        return $this->ExerciseDiffuclty[$i];
    }

    /**
     * Retourne un métier au hasard
     */
    public function advice($i)
    {
        return $this->advice[$i];
    }


}
