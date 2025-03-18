export default L.extend(Localization, {
    'en': {
        directions: {
            N: 'north',
            NE: 'northeast',
            E: 'east',
            SE: 'southeast',
            S: 'south',
            SW: 'southwest',
            W: 'west',
            NW: 'northwest',
            SlightRight: 'slight right',
            Right: 'right',
            SharpRight: 'sharp right',
            SlightLeft: 'slight left',
            Left: 'left',
            SharpLeft: 'sharp left',
            Uturn: 'Turn around'
        },
        instructions: {
            // instruction, postfix if the road is named
            'Head':
                ['Head {dir}', ' on {road}'],
            'Continue':
                ['Tiếp tục theo {dir}'],
            'TurnAround':
                ['Turn around'],
            'WaypointReached':
                ['Waypoint reached'],
            'Roundabout':
                ['Take the {exitStr} exit in the roundabout', ' onto {road}'],
            'DestinationReached':
                ['Destination reached'],
            'Fork': ['At the fork, turn {modifier}', ' onto {road}'],
            'Merge': ['Merge {modifier}', ' onto {road}'],
            'OnRamp': ['Turn {modifier} on the ramp', ' onto {road}'],
            'OffRamp': ['Take the ramp on the {modifier}', ' onto {road}'],
            'EndOfRoad': ['Turn {modifier} at the end of the road', ' onto {road}'],
            'Onto': 'onto {road}'
        },
        formatOrder: function(n) {
            var i = n % 10 - 1,
            suffix = ['st', 'nd', 'rd'];

            return suffix[i] ? n + suffix[i] : n + 'th';
        },
        ui: {
            startPlaceholder: 'Start',
            viaPlaceholder: 'Via {viaNumber}',
            endPlaceholder: 'End'
        },
        units: {
            meters: 'm',
            kilometers: 'km',
            yards: 'yd',
            miles: 'mi',
            hours: 'h',
            minutes: 'min',
            seconds: 's'
        }
    },
})