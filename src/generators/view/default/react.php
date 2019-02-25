<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "";
?>

<div id="root"></div>

<script type="text/babel">
    class <?= $generator->reactClassName ?> extends React.Component {		
        constructor(props) {
            super(props);

            this.state = {
                
            };
        }

        render() {
            return (
                <div className="container">
                    here comes the sun
                </div>           			
            );              
        }	
    }

    ReactDOM.render(
        <<?= $generator->reactClassName ?> />,
        document.getElementById('root')
    );
</script>